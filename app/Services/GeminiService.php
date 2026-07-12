<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    /**
     * Generate an itinerary using Gemini API (or fallback mock)
     */
    public function generateItinerary(string $destination, int $days, float $budget, array $interests): array
    {
        $interestsStr = implode(', ', $interests);
        $prompt = "Generate a daily travel itinerary for a trip to '{$destination}' for {$days} days. " .
                  "The budget is {$budget} INR (Indian Rupees, ₹) and the traveler's interests are: {$interestsStr}. " .
                  "You must return ONLY a valid JSON object. Do not wrap it in markdown code blocks like ```json. " .
                  "You must calculate and return all activity costs and the total estimated cost in Indian Rupees (INR). " .
                  "The JSON structure must match this example exactly:\n" .
                  "{\n" .
                  "  \"title\": \"Epic Adventure in {$destination}\",\n" .
                  "  \"destination\": \"{$destination}\",\n" .
                  "  \"days_count\": {$days},\n" .
                  "  \"total_estimated_cost\": 0,\n" .
                  "  \"days\": [\n" .
                  "    {\n" .
                  "      \"day\": 1,\n" .
                  "      \"theme\": \"Exploring the Classics\",\n" .
                  "      \"activities\": [\n" .
                  "        {\n" .
                  "          \"time\": \"09:00 AM\",\n" .
                  "          \"title\": \"Visit Major Landmark\",\n" .
                  "          \"description\": \"A detailed description of what to do here, sights to see, and tips.\",\n" .
                  "          \"cost\": 500,\n" .
                  "          \"category\": \"activities\"\n" .
                  "        }\n" .
                  "      ]\n" .
                  "    }\n" .
                  "  ]\n" .
                  "}\n" .
                  "Make sure total_estimated_cost is the sum of all activity costs and is within the budget constraint. " .
                  "Keep activity categories selected from: food, transport, accommodation, activities, shopping, other.";

        if ($this->apiKey) {
            try {
                $response = Http::timeout(10)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'responseMimeType' => 'application/json'
                    ]
                ]);

                if ($response->successful()) {
                    $result = $response->json();
                    $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    
                    // Clean up any markdown code blocks just in case
                    $text = trim($text);
                    if (str_starts_with($text, '```')) {
                        $text = preg_replace('/^```(?:json)?\n?|```$/i', '', $text);
                    }
                    $text = trim($text);

                    $data = json_decode($text, true);
                    if (is_array($data)) {
                        return $data;
                    }
                }
                Log::warning('Gemini API call failed or returned invalid JSON. Using mock fallback.');
            } catch (\Exception $e) {
                Log::error('Gemini API Exception: ' . $e->getMessage());
            }
        }

        return $this->generateMockItinerary($destination, $days, $budget, $interests);
    }

    /**
     * Check if the query message is travel-related
     */
    public function isTravelRelated(string $message): bool
    {
        $msgLower = strtolower(trim($message));

        // Blacklist terms targeting coding, advanced mathematics, politics, and academic science
        $blacklist = [
            'python', 'javascript', 'c++', 'java', 'php code', 'html', 'css', 'sql', 'programming', 'coding', 
            'algorithm', 'calculus', 'algebra', 'physics', 'chemistry', 'biology', 'photosynthesis', 'fibonacci', 
            'prime number', 'write code', 'software develop', 'code function', 'solve for x', 'einstein', 'schrodinger',
            'quantum mechanics', 'mitosis', 'meiosis', 'cell division', 'general relativity'
        ];

        foreach ($blacklist as $term) {
            if (str_contains($msgLower, $term)) {
                return false;
            }
        }

        // Detect mathematical calculations using regex (e.g., 2 + 2, 25 * 4, 100 / 5)
        if (preg_match('/[0-9]+\s*[\+\-\*\/]\s*[0-9]+/', $msgLower)) {
            return false;
        }

        // Allow all other inquiries to be processed by the LLM (or mock travel assistant)
        return true;
    }

    /**
     * Context-aware chatbot assistant responses (or fallback mock)
     */
    public function getChatResponse(array $history, string $newMessage): string
    {
        // Enforce travel-related inquiries only
        if (!$this->isTravelRelated($newMessage)) {
            return "I apologize, but I am programmed to only answer queries related to travel, tourism, destinations, tour packages, hotels, vehicles, itineraries, and travel tips. How can I help you plan your next journey?";
        }

        if ($this->apiKey) {
            try {
                $contents = [];
                // Build history for Gemini format
                foreach ($history as $msg) {
                    $contents[] = [
                        'role' => $msg['is_bot'] ? 'model' : 'user',
                        'parts' => [['text' => $msg['message']]]
                    ];
                }
                // Add the new message
                $contents[] = [
                    'role' => 'user',
                    'parts' => [['text' => $newMessage]]
                ];

                $systemInstruction = "You are GlobeFly Bot, a premium AI travel assistant for GlobeFly Adventures. " .
                                     "You MUST ONLY answer questions related to travel, tourism, destinations, tour packages, hotels, vehicles, itineraries, and travel tips. " .
                                     "You must calculate and mention travel costs or pricing in Indian Rupees (INR, ₹). " .
                                     "If the user asks about anything else (such as coding, math, general science, politics, or unrelated topics), you must politely decline to answer, stating that you are dedicated solely to travel-related inquiries. Keep answers concise, clear, and format them with markdown.";

                $response = Http::timeout(10)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $this->apiKey, [
                    'contents' => $contents,
                    'systemInstruction' => [
                        'parts' => [['text' => $systemInstruction]]
                    ]
                ]);

                if ($response->successful()) {
                    $result = $response->json();
                    return $result['candidates'][0]['content']['parts'][0]['text'] ?? 'I apologize, but I could not formulate a response at the moment.';
                }
            } catch (\Exception $e) {
                Log::error('Gemini Chat Exception: ' . $e->getMessage());
            }
        }

        return $this->generateMockChatResponse($newMessage);
    }

    /**
     * Generate structured Mock Itinerary based on destination and preferences
     */
    protected function generateMockItinerary(string $destination, int $days, float $budget, array $interests): array
    {
        $destLower = strtolower($destination);
        $title = "Scenic & Customized Tour of " . ucwords($destination);
        $estimatedCost = 0.0;
        $daysArray = [];

        // Define a database of mock activities per destination (Indian popular places, costs in Rupees)
        $sights = [
            'taj' => [
                ['title' => 'Taj Mahal Sunrise Tour', 'description' => 'Experience the breathtaking beauty of the Taj Mahal at sunrise. Watch the white marble glow in soft pink morning light.', 'cost' => 500.0, 'category' => 'activities'],
                ['title' => 'Agra Fort Guided Walk', 'description' => 'Explore the historic red sandstone fortress of Agra, a UNESCO World Heritage site.', 'cost' => 600.0, 'category' => 'activities'],
                ['title' => 'Mughlai Dinner at Pintail Restaurant', 'description' => 'Enjoy a lavish traditional dinner featuring Mughlai seekh kebabs, butter chicken, and biryani.', 'cost' => 1200.0, 'category' => 'food'],
                ['title' => 'Mehtab Bagh Sunset Walk', 'description' => 'Walk through the moonlight garden located across the Yamuna river for a perfect sunset view of the Taj Mahal.', 'cost' => 200.0, 'category' => 'activities'],
                ['title' => 'Marble Inlay Shopping', 'description' => 'Visit local Agra artisans to shop for marble handicrafts and inlay souvenirs.', 'cost' => 1000.0, 'category' => 'shopping'],
                ['title' => 'Tomb of Itimad-ud-Daulah (Baby Taj)', 'description' => 'Tour the exquisite draft mausoleum often described as the blueprint for the Taj Mahal.', 'cost' => 300.0, 'category' => 'activities']
            ],
            'agra' => [
                ['title' => 'Taj Mahal Sunrise Tour', 'description' => 'Experience the breathtaking beauty of the Taj Mahal at sunrise. Watch the white marble glow in soft pink morning light.', 'cost' => 500.0, 'category' => 'activities'],
                ['title' => 'Agra Fort Guided Walk', 'description' => 'Explore the historic red sandstone fortress of Agra, a UNESCO World Heritage site.', 'cost' => 600.0, 'category' => 'activities'],
                ['title' => 'Mughlai Dinner at Pintail Restaurant', 'description' => 'Enjoy a lavish traditional dinner featuring Mughlai seekh kebabs, butter chicken, and biryani.', 'cost' => 1200.0, 'category' => 'food'],
                ['title' => 'Mehtab Bagh Sunset Walk', 'description' => 'Walk through the moonlight garden located across the Yamuna river for a perfect sunset view of the Taj Mahal.', 'cost' => 200.0, 'category' => 'activities'],
                ['title' => 'Marble Inlay Shopping', 'description' => 'Visit local Agra artisans to shop for marble handicrafts and inlay souvenirs.', 'cost' => 1000.0, 'category' => 'shopping'],
                ['title' => 'Tomb of Itimad-ud-Daulah (Baby Taj)', 'description' => 'Tour the exquisite draft mausoleum often described as the blueprint for the Taj Mahal.', 'cost' => 300.0, 'category' => 'activities']
            ],
            'kerala' => [
                ['title' => 'Private Houseboat Cruise', 'description' => 'Board a traditional thatched-roof Kettuvallam and glide past serene coconut grooves and villages on Alleppey backwaters.', 'cost' => 3500.0, 'category' => 'activities'],
                ['title' => 'Munnar Tea Garden Expedition', 'description' => 'Hike through lush green tea estate terraces in Munnar and taste fresh organic tea leaves.', 'cost' => 500.0, 'category' => 'activities'],
                ['title' => 'Traditional Kathakali Dance Drama', 'description' => 'Watch the elaborate make-up ritual and intense dramatic performance of Kathakali actors.', 'cost' => 600.0, 'category' => 'activities'],
                ['title' => 'Ayurvedic Body Rejuvenation Spa', 'description' => 'Relax with an authentic full-body oil massage (Abhyanga) at a certified wellness sanctuary.', 'cost' => 2000.0, 'category' => 'activities'],
                ['title' => 'Spicy Malabar Coast Lunch', 'description' => 'Indulge in fresh Karimeen Pollichathu (pearl spot fish) and banana leaf rice.', 'cost' => 800.0, 'category' => 'food'],
                ['title' => 'Periyar Wildlife Sanctuary Lake Boating', 'description' => 'Boat cruise through the scenic lake looking for wild elephants, bisons, and rare birds.', 'cost' => 450.0, 'category' => 'activities']
            ],
            'goa' => [
                ['title' => 'Baga Beach Parasailing & Water Sports', 'description' => 'Fly high above the Arabian Sea and experience jet skiing and banana boat rides on the waves.', 'cost' => 1800.0, 'category' => 'activities'],
                ['title' => 'Old Goa Basilica Tour', 'description' => 'Visit the historical 17th-century Basilica of Bom Jesus, holding the mortal remains of St. Francis Xavier.', 'cost' => 0.0, 'category' => 'activities'],
                ['title' => 'Seafood Dinner at Curlies Shack', 'description' => 'Dine directly on the sand with candlelit tables serving Goan fish curry, prawns, and classic local bread.', 'cost' => 1500.0, 'category' => 'food'],
                ['title' => 'Dudhsagar Waterfalls Jeep Safari', 'description' => 'Take a rugged off-road drive through Mollem National Park to witness the four-tiered milk-like cascades.', 'cost' => 1200.0, 'category' => 'activities'],
                ['title' => 'Anjuna Flea Market Souvenirs', 'description' => 'Shop for beachwear, local hand-woven spices, trinkets, and Rajasthani patchworks.', 'cost' => 800.0, 'category' => 'shopping'],
                ['title' => 'Fontainhas Latin Quarter Stroll', 'description' => 'Take a walk through the charming Portuguese-style streets of Panaji, filled with pastel yellow and blue villas.', 'cost' => 0.0, 'category' => 'activities']
            ],
            'jaipur' => [
                ['title' => 'Amer Fort Jeep Ascent', 'description' => 'Scale the hill slopes to Amer Fort to view the dazzling Sheesh Mahal (Hall of Mirrors).', 'cost' => 800.0, 'category' => 'activities'],
                ['title' => 'Chokhi Dhani Cultural Village', 'description' => 'Immerse in local heritage with folk dances, camel rides, and an authentic Rajasthani ghee-laden dinner.', 'cost' => 1200.0, 'category' => 'food'],
                ['title' => 'Hawa Mahal & City Palace Walk', 'description' => 'Photograph the iconic honeycomb pink facade of Hawa Mahal and tour the royal museums.', 'cost' => 400.0, 'category' => 'activities'],
                ['title' => 'Shopping at Johari Bazar', 'description' => 'Browse through Jaipur markets famous for gemstone jewelry, block-printed textiles, and blue pottery.', 'cost' => 1500.0, 'category' => 'shopping'],
                ['title' => 'Jantar Mantar Astronomical Tour', 'description' => 'Explore the UNESCO site featuring the world\'s largest stone sundial and scientific instruments.', 'cost' => 200.0, 'category' => 'activities']
            ],
            'ladakh' => [
                ['title' => 'Pangong Lake Scenic Drive', 'description' => 'Travel across Chang La pass to view the surreal blue waters of Pangong Tso, spanning India and Tibet.', 'cost' => 4000.0, 'category' => 'activities'],
                ['title' => 'Thiksey Monastery Sunrise Prayer', 'description' => 'Listen to the deep Buddhist chants of morning prayers at the twelve-story monastery hill.', 'cost' => 100.0, 'category' => 'activities'],
                ['title' => 'Magnetic Hill & Confluence Visit', 'description' => 'See your vehicle defy gravity at Magnetic Hill, then visit the confluence of Indus and Zanskar rivers.', 'cost' => 0.0, 'category' => 'activities'],
                ['title' => 'Leh Palace Exploration', 'description' => 'Walk through the corridors of the historic 9-story palace overlooking Leh town.', 'cost' => 250.0, 'category' => 'activities'],
                ['title' => 'Local Ladakhi Thukpa & Momo Dinner', 'description' => 'Enjoy hot noodle soup and steamed mutton dumplings at a warm local kitchen.', 'cost' => 600.0, 'category' => 'food']
            ]
        ];

        // Fetch standard list or use a dynamically generated default template
        $activeSights = [];
        foreach ($sights as $key => $sightList) {
            if (str_contains($destLower, $key)) {
                $activeSights = $sightList;
                $title = "AI Recommended Trip to " . ucwords($key);
                break;
            }
        }

        if (empty($activeSights)) {
            // Generate dynamic generic sights (INR pricing)
            $activeSights = [
                ['title' => 'Downtown Heritage Walking Tour', 'description' => 'Discover the local history, major architectural highlights, and vibrant public squares.', 'cost' => 500.0, 'category' => 'activities'],
                ['title' => 'Popular Local Museum Visit', 'description' => 'Browse art galleries, archaeological treasures, and interactive historical exhibits.', 'cost' => 300.0, 'category' => 'activities'],
                ['title' => 'Tasting Local Street Specialties', 'description' => 'Visit the central food stalls to sample popular street foods, pastries, and signature drinks.', 'cost' => 800.0, 'category' => 'food'],
                ['title' => 'Scenic Viewpoint Hike', 'description' => 'Climb or ride to the highest point in town for a sweeping panoramic view of the area.', 'cost' => 400.0, 'category' => 'activities'],
                ['title' => 'Nature Reserve Day Excursion', 'description' => 'Travel just outside the border to hike trails, see waterfalls, and enjoy fresh air.', 'cost' => 1500.0, 'category' => 'activities'],
                ['title' => 'Souvenir Shopping at Local Markets', 'description' => 'Shop handcrafts, local spices, and artwork directly from independent vendors.', 'cost' => 1000.0, 'category' => 'shopping'],
                ['title' => 'Bistro Dining Experience', 'description' => 'Enjoy an elegant dinner featuring regional cuisine at a highly recommended hotel.', 'cost' => 1500.0, 'category' => 'food']
            ];
        }

        // Accommodation daily cost allocation depending on budget
        $dailyHotelCost = ($budget / $days) * 0.4; // Allocate 40% of budget to lodging
        if ($dailyHotelCost < 2000) $dailyHotelCost = 2000.0;

        for ($d = 1; $d <= $days; $d++) {
            $dayActivities = [];
            
            // Add lodging cost every day
            $dayActivities[] = [
                'time' => '08:00 AM',
                'title' => 'Comfortable Hotel Stay',
                'description' => 'Overnight stay at a highly rated accommodation located centrally.',
                'cost' => round($dailyHotelCost, 2),
                'category' => 'accommodation'
            ];
            $estimatedCost += $dailyHotelCost;

            // Pick 2 random sights for this day
            $sightIndex1 = ($d * 2 - 2) % count($activeSights);
            $sightIndex2 = ($d * 2 - 1) % count($activeSights);

            $s1 = $activeSights[$sightIndex1];
            $s2 = $activeSights[$sightIndex2];

            $dayActivities[] = [
                'time' => '10:00 AM',
                'title' => $s1['title'],
                'description' => $s1['description'],
                'cost' => $s1['cost'],
                'category' => $s1['category']
            ];
            $estimatedCost += $s1['cost'];

            $dayActivities[] = [
                'time' => '03:00 PM',
                'title' => $s2['title'],
                'description' => $s2['description'],
                'cost' => $s2['cost'],
                'category' => $s2['category']
            ];
            $estimatedCost += $s2['cost'];

            // Add standard transport daily allowance (Rupees)
            $transportCost = 500.0;
            $dayActivities[] = [
                'time' => '08:00 PM',
                'title' => 'Local Metro & Taxi Transport',
                'description' => 'Daily passes for public transport or short ride-sharing commutes.',
                'cost' => $transportCost,
                'category' => 'transport'
            ];
            $estimatedCost += $transportCost;

            $daysArray[] = [
                'day' => $d,
                'theme' => 'Highlights of Day ' . $d,
                'activities' => $dayActivities
            ];
        }

        return [
            'title' => $title,
            'destination' => ucwords($destination),
            'days_count' => $days,
            'total_estimated_cost' => round($estimatedCost, 2),
            'days' => $daysArray
        ];
    }

    /**
     * Generate context-aware Mock Chat response (Indian tourist destinations, Rupees, strictly travel only)
     */
    protected function generateMockChatResponse(string $message): string
    {
        $msgLower = strtolower($message);

        if (str_contains($msgLower, 'hello') || str_contains($msgLower, 'hi ') || $msgLower === 'hi') {
            return "Namaste! 👋 I am the GlobeFly AI Travel Assistant. How can I help you plan your dream vacation across beautiful Indian sites today? You can ask me to recommend packages, hotels, or give you travel tips.";
        }

        if (str_contains($msgLower, 'taj') || str_contains($msgLower, 'agra')) {
            return "The iconic Taj Mahal in Agra! 🇮🇳 Here are my top recommendations:\n\n" .
                   "- **Attractions**: Taj Mahal (Sunrise view is majestic!), Agra Fort, Mehtab Bagh, and Baby Taj.\n" .
                   "- **Hotel recommendation**: *The Imperial Agra Palace* (5-star luxury near Taj Gate, starting at ₹12,500/night).\n" .
                   "- **Travel Tip**: The Taj Mahal is closed on Fridays. Book tickets online in advance to bypass ticket counter lines!";
        }

        if (str_contains($msgLower, 'goa')) {
            return "Goa, the coastal paradise of India! 🏖️ My recommendations:\n\n" .
                   "- **Attractions**: Candolim Beach, Old Goa Basilica of Bom Jesus, Dudhsagar Waterfalls jeep ride, and Latin Quarter Fontainhas.\n" .
                   "- **Hotel recommendation**: *The Palms Shore Resort* (5-star beachfront, private pool villas at ₹18,000/night).\n" .
                   "- **Travel Tip**: Rent a scooter or local car to explore North and South Goa easily. Try water sports in Calangute or Baga beach!";
        }

        if (str_contains($msgLower, 'kerala')) {
            return "Kerala, God's Own Country! 🌴 Top highlights:\n\n" .
                   "- **Attractions**: Alleppey Houseboat Backwater cruise, Munnar Tea Gardens, and Periyar Wildlife Sanctuary lake boating.\n" .
                   "- **Hotel recommendation**: *Kumarakom Backwater Sanctuary* (Ayurvedic heritage cottages starting at ₹8,900/night).\n" .
                   "- **Travel Tip**: Monsoons (June-September) are spectacular for herbal wellness treatments, while winter is best for general houseboat touring.";
        }

        if (str_contains($msgLower, 'jaipur') || str_contains($msgLower, 'rajasthan')) {
            return "Jaipur, the Royal Pink City of Rajasthan! 🏰 My recommendations:\n\n" .
                   "- **Attractions**: Amer Fort mirror hall, Hawa Mahal (Palace of Winds), Jantar Mantar, and Johari Bazar shopping.\n" .
                   "- **Food tip**: Visit Chokhi Dhani ethnic village for Rajasthani folk dances and traditional Dal Baati Churma dining.\n" .
                   "- **Travel Tip**: Hire a local certified guide at Amer Fort to learn about the rich history of Rajput dynasties.";
        }

        if (str_contains($msgLower, 'ladakh')) {
            return "Ladakh, the high-altitude Cold Desert! 🏔️ Recommendations:\n\n" .
                   "- **Attractions**: Pangong Tso Lake (deep blue salt lake), Thiksey Monastery, and gravity-defying Magnetic Hill.\n" .
                   "- **Travel Tip**: Rest completely for the first 24-48 hours in Leh to acclimatize to high altitude. Keep heavy warm layers, as temperatures drop rapidly.";
        }

        if (str_contains($msgLower, 'hotel') || str_contains($msgLower, 'stay') || str_contains($msgLower, 'accommodat')) {
            return "We partner with premium luxury hotels across India! 🏨 On our **Hotels** page, you can reserve rooms directly at places like:\n\n" .
                   "1. **The Imperial Agra Palace** (Agra) - Heritage suites with private Taj Mahal terraces starting at ₹12,500/night.\n" .
                   "2. **Kumarakom Backwater Sanctuary** (Kerala) - Traditional Ayurvedic cottages on Vembanad lake starting at ₹8,900/night.\n" .
                   "3. **The Palms Shore Resort** (Goa) - Beachfront plunge pool villas starting at ₹18,000/night.\n\n" .
                   "Would you like me to guide you on how to book a room?";
        }

        if (str_contains($msgLower, 'package') || str_contains($msgLower, 'tour') || str_contains($msgLower, 'book')) {
            return "Looking for a structured adventure? 🎒 We offer fully organized **Tour Packages** including:\n\n" .
                   "- *Golden Triangle & Taj Mahal Heritage* (4 Days, Agra/Delhi) - ₹24,999\n" .
                   "- *Kerala Backwaters & Houseboat Cruise* (6 Days, Alleppey) - ₹32,000\n" .
                   "- *Sunny Goa Beach Adventure* (5 Days, Candolim) - ₹18,500\n" .
                   "- *Royal Jaipur & Rajasthani Desert Forts* (5 Days, Jaipur) - ₹27,500\n\n" .
                   "Each package includes guided sightseeing, premium hotel stays, and transportation. Check them out in detail under our **Tour Packages** tab!";
        }

        if (str_contains($msgLower, 'budget') || str_contains($msgLower, 'cost') || str_contains($msgLower, 'price')) {
            return "Planning your finances? 💰 GlobeFly features a built-in **Financial Planner & Expense Tracker** in Rupees! " .
                   "When you generate an AI itinerary, you can save it and log daily costs (meals, souvenirs, transit in ₹). " .
                   "Our interactive charts will show you your budget breakdown and warn you if you are overspending.";
        }

        return "I appreciate your message! 🗺️ As your GlobeFly travel assistant, I can help you find destinations, estimate budgets, " .
               "or plan daily schedules across India. Let me know if you would like recommendations for Taj Mahal, Goa, Kerala, Jaipur, or Ladakh!";
    }
}
