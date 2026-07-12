<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Users (one for each role, with Indian Names)
        $admin = User::create([
            'name' => 'Aarav Sharma (Admin)',
            'email' => 'admin@globefly.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+919876543210',
            'bio' => 'System administrator for the GlobeFly Adventures travel portal.',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80'
        ]);

        $manager = User::create([
            'name' => 'Vikram Malhotra (Tour Manager)',
            'email' => 'manager@globefly.com',
            'password' => Hash::make('password'),
            'role' => 'tour_manager',
            'phone' => '+919876543211',
            'bio' => 'Experienced tour director organizing packages across beautiful Indian sites and cultural hubs.',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80'
        ]);

        $partner = User::create([
            'name' => 'Priyanka Sen (Hotel Partner)',
            'email' => 'partner@globefly.com',
            'password' => Hash::make('password'),
            'role' => 'hotel_partner',
            'phone' => '+919876543212',
            'bio' => 'Boutique hotel developer focusing on unique cultural hospitality spaces in India.',
            'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80'
        ]);

        $traveler = User::create([
            'name' => 'Rohan Joshi (Traveler)',
            'email' => 'traveler@globefly.com',
            'password' => Hash::make('password'),
            'role' => 'traveler',
            'phone' => '+919876543213',
            'bio' => 'Explorer seeking historical trails, natural backwaters, beach escapes, and deep cultural immersions.',
            'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&q=80'
        ]);

        // 2. Seed Destinations (Indian & Foreign)
        $tajMahal = Destination::create([
            'name' => 'Taj Mahal',
            'slug' => 'taj-mahal',
            'location' => 'Agra, India',
            'description' => 'Witness the world-famous white marble architectural masterpiece built by Emperor Shah Jahan in memory of his beloved wife Mumtaz Mahal. A timeless symbol of love.',
            'coordinates' => '27.1751, 78.0421',
            'weather_info' => 'Pleasant winters (10°C - 20°C). Summers are hot. Sunset or sunrise visits offer the most breathtaking views.',
            'image_url' => 'https://images.unsplash.com/photo-1564507592333-c60657eea523?auto=format&fit=crop&w=1200&q=80'
        ]);

        $kerala = Destination::create([
            'name' => 'Kerala Backwaters',
            'slug' => 'kerala-backwaters',
            'location' => 'Kerala, India',
            'description' => 'Unwind in "God\'s Own Country", featuring serene palm-fringed houseboats, emerald green lagoons, spice plantations, and ancient Ayurvedic wellness sanctuaries.',
            'coordinates' => '10.8505, 76.2711',
            'weather_info' => 'Tropical warm climate (24°C - 32°C). Monsoon season (June to September) is perfect for traditional Ayurvedic treatments.',
            'image_url' => 'https://images.unsplash.com/photo-1593693397690-362cb9666fc2?auto=format&fit=crop&w=1200&q=80'
        ]);

        $goa = Destination::create([
            'name' => 'Goa Beaches',
            'slug' => 'goa-beaches',
            'location' => 'Goa, India',
            'description' => 'A sparkling coastal paradise blending historical Portuguese architecture, golden sand beaches, thrilling water sports, and beach shacks serving local seafood.',
            'coordinates' => '15.2993, 74.1240',
            'weather_info' => 'Tropical maritime (22°C - 32°C). Best beach climate spans from October to February.',
            'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80'
        ]);

        $jaipur = Destination::create([
            'name' => 'Jaipur Pink City',
            'slug' => 'jaipur',
            'location' => 'Rajasthan, India',
            'description' => 'Discover the magnificent royal forts, imperial palaces, and colorful bazaars of Rajasthan\'s capital, characterized by its distinctive pink-painted heritage buildings.',
            'coordinates' => '26.9124, 75.7873',
            'weather_info' => 'Dry warm climate. Cool winter evenings (8°C - 20°C) make it perfect for sightseeing.',
            'image_url' => 'https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=1200&q=80'
        ]);

        $ladakh = Destination::create([
            'name' => 'Ladakh Peaks',
            'slug' => 'ladakh',
            'location' => 'Ladakh, India',
            'description' => 'A high-altitude paradise featuring dramatic snow-capped passes, pristine deep-blue lakes like Pangong Tso, and century-old Buddhist monasteries.',
            'coordinates' => '34.1526, 77.5770',
            'weather_info' => 'Cold desert alpine. Bright summer days (15°C - 25°C), while winters drop far below freezing.',
            'image_url' => 'https://images.unsplash.com/photo-1598091383021-15ddea10925d?auto=format&fit=crop&w=1200&q=80'
        ]);

        // Foreign Destinations
        $paris = Destination::create([
            'name' => 'Paris',
            'slug' => 'paris',
            'location' => 'Paris, France',
            'description' => 'The world capital of art, fashion, gastronomy, and culture. Adorned with 19th-century streetscapes, the Eiffel Tower, Louvre Museum, and romantic Seine river cruises.',
            'coordinates' => '48.8566, 2.3522',
            'weather_info' => 'Temperate climate (5°C in winter, 25°C in summer). Spring (April-June) and Autumn (Sept-Nov) are highly recommended.',
            'image_url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1200&q=80'
        ]);

        $kyoto = Destination::create([
            'name' => 'Kyoto Zen Gardens',
            'slug' => 'kyoto',
            'location' => 'Kyoto, Japan',
            'description' => 'Immerse in Japan\'s historic imperial heart, famous for hundreds of classical Zen temples, Shinto shrines, traditional wooden houses, and cherry blossom viewpoints.',
            'coordinates' => '35.0116, 135.7681',
            'weather_info' => 'Humid temperate. Spring cherry blossoms (April) and Autumn maple foliage (November) are visually magnificent.',
            'image_url' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=1200&q=80'
        ]);

        $bali = Destination::create([
            'name' => 'Bali Tropical Island',
            'slug' => 'bali',
            'location' => 'Bali, Indonesia',
            'description' => 'An exotic Indonesian island celebrated for its forested volcanic mountains, iconic terraced rice paddies, sandy beaches, and rich cultural heritage.',
            'coordinates' => '-8.4095, 115.1889',
            'weather_info' => 'Tropical monsoon (26°C - 31°C). Dry season runs from April to October and is perfect for coastal adventures.',
            'image_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80'
        ]);

        $swissAlps = Destination::create([
            'name' => 'Swiss Alps',
            'slug' => 'swiss-alps',
            'location' => 'Interlaken, Switzerland',
            'description' => 'A jaw-dropping alpine wonderland. Travel on cogwheel railways to snow-covered peaks, hike pristine meadows, and stay in cozy Swiss chalets overlooking turquoise lakes.',
            'coordinates' => '46.6863, 7.8632',
            'weather_info' => 'Alpine climate. Perfect for summer hiking (June-August) or winter alpine skiing (December-March).',
            'image_url' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1200&q=80'
        ]);

        $dubai = Destination::create([
            'name' => 'Dubai Modern Oasis',
            'slug' => 'dubai',
            'location' => 'Dubai, UAE',
            'description' => 'A futuristic desert metropolis famous for high-end luxury shopping, ultra-modern architecture like Burj Khalifa, dune-bashing safaris, and lively nightlife.',
            'coordinates' => '25.2048, 55.2708',
            'weather_info' => 'Hot desert climate. Best traveled during cooler winter months (November to March, 18°C - 28°C).',
            'image_url' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=80'
        ]);

        // Additional Indian Destinations
        $manali = Destination::create([
            'name' => 'Manali Valleys',
            'slug' => 'manali',
            'location' => 'Himachal Pradesh, India',
            'description' => 'A popular high-altitude Himalayan resort town known for backpacking, skiing, paragliding, rafting, and the stunning Solang and Rohtang Valleys.',
            'coordinates' => '32.2396, 77.1887',
            'weather_info' => 'Cold alpine climate. Snowy winters (-2°C to 10°C) and pleasant summers (10°C to 25°C). Ideal for snow sports.',
            'image_url' => 'https://images.unsplash.com/photo-1605649487212-47bdab064df7?auto=format&fit=crop&w=1200&q=80'
        ]);

        $varanasi = Destination::create([
            'name' => 'Varanasi Ganga Ghats',
            'slug' => 'varanasi',
            'location' => 'Uttar Pradesh, India',
            'description' => 'One of the oldest continuously inhabited cities in the world. Famous for its spiritual river ghats, winding alleyways, and the divine evening Ganga Aarti.',
            'coordinates' => '25.3176, 82.9739',
            'weather_info' => 'Humid subtropical. Best visited in cooler winter months (October to March, 10°C to 25°C) to witness daily rituals.',
            'image_url' => 'https://images.unsplash.com/photo-1561361060-6644fcfc5a45?auto=format&fit=crop&w=1200&q=80'
        ]);

        // Additional Foreign Destinations
        $newYork = Destination::create([
            'name' => 'New York City',
            'slug' => 'new-york',
            'location' => 'New York, USA',
            'description' => 'The Big Apple. An iconic metropolis featuring towering skyscrapers, Broadway theater, Central Park, and the historic Statue of Liberty.',
            'coordinates' => '40.7128, -74.0060',
            'weather_info' => 'Humid continental. Hot summers (18°C to 28°C) and snowy, scenic winters (-3°C to 5°C).',
            'image_url' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=1200&q=80'
        ]);

        $rome = Destination::create([
            'name' => 'Rome Historic Center',
            'slug' => 'rome',
            'location' => 'Rome, Italy',
            'description' => 'The Eternal City. Imbibed with thousands of years of art, architecture, and history, featuring the Colosseum, Roman Forum, and Vatican City.',
            'coordinates' => '41.9028, 12.4964',
            'weather_info' => 'Mediterranean climate (7°C in winter, 30°C in summer). Perfect for foot explorations in Spring/Autumn.',
            'image_url' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=1200&q=80'
        ]);

        $london = Destination::create([
            'name' => 'London Capital',
            'slug' => 'london',
            'location' => 'London, UK',
            'description' => 'A royal historic capital situated on the River Thames. Highlights include Tower Bridge, the London Eye, Buckingham Palace, and world-class museums.',
            'coordinates' => '51.5074, -0.1278',
            'weather_info' => 'Temperate maritime (4°C to 22°C). Light rain is common; carrying an umbrella is recommended.',
            'image_url' => 'https://images.unsplash.com/photo-1513635269975-59663e0ca1ad?auto=format&fit=crop&w=1200&q=80'
        ]);


        // 3. Seed Tour Packages (managed by Vikram Malhotra, prices in Rupees)
        TourPackage::create([
            'name' => 'Golden Triangle & Taj Mahal Heritage',
            'description' => 'Explore the majestic Taj Mahal in Agra, Agra Red Fort, and Delhi\'s imperial quarters. Package includes fast-track entry tickets, private local guide, luxury hotel stay, and traditional North Indian culinary experiences.',
            'price' => 24999.00,
            'duration_days' => 4,
            'destination_id' => $tajMahal->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1548013146-72479768bada?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 15,
            'available_slots' => 15,
            'start_date' => '2026-07-15',
            'end_date' => '2026-07-19',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Kerala Backwaters & Houseboat Cruise',
            'description' => 'Relax on a private deluxe houseboat winding through Alleppey backwaters. Enjoy freshly prepared Keralite cuisine, tour spice plantations in Munnar, and experience therapeutic Ayurvedic massage sessions.',
            'price' => 32000.00,
            'duration_days' => 6,
            'destination_id' => $kerala->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1593693397690-362cb9666fc2?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 12,
            'available_slots' => 12,
            'start_date' => '2026-08-10',
            'end_date' => '2026-08-16',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Sunny Goa Beach Adventure',
            'description' => 'Indulge in an exciting coastal break in Goa. Includes beach parasailing, scuba diving, private heritage tours of Old Goa churches, seafood shack dinner credits, and resort stay near Candolim beach.',
            'price' => 18500.00,
            'duration_days' => 5,
            'destination_id' => $goa->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 20,
            'available_slots' => 20,
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-06',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Royal Jaipur & Rajasthani Desert Forts',
            'description' => 'Immerse in the royalty of Rajasthan. Visit Amer Fort, witness heritage puppet shows, stay at a restored heritage palace hotel, and experience a desert camel safari under the stars.',
            'price' => 27500.00,
            'duration_days' => 5,
            'destination_id' => $jaipur->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1599661046289-e31897846e41?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 10,
            'available_slots' => 10,
            'start_date' => '2026-07-28',
            'end_date' => '2026-08-02',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Ladakh High-Pass Adventure & Pangong Lake',
            'description' => 'Journey across high altitude roads. Tour ancient Buddhist monasteries in Leh, drive through Khardung La (one of the world\'s highest motorable passes), and camp alongside the pristine Pangong Lake.',
            'price' => 38000.00,
            'duration_days' => 7,
            'destination_id' => $ladakh->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1598091383021-15ddea10925d?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 10,
            'available_slots' => 10,
            'start_date' => '2026-08-20',
            'end_date' => '2026-08-27',
            'status' => 'active'
        ]);

        // Foreign Packages
        TourPackage::create([
            'name' => 'Eiffel Tower Romance & Parisian Art Tour',
            'description' => 'A dream European holiday. Skip-the-line Eiffel Tower summit tour, private Louvre guided art tour, scenic Seine River dining cruise, and high-end boutique hotel accommodations.',
            'price' => 149999.00,
            'duration_days' => 7,
            'destination_id' => $paris->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 8,
            'available_slots' => 8,
            'start_date' => '2026-09-10',
            'end_date' => '2026-09-17',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Kyoto Zen Temples & Heritage Tea Ceremony',
            'description' => 'Experience the rich culture of Japan. Walk the Golden Pavilion, stroll Fushimi Inari Shrine gates, witness an authentic geisha performance, and participate in a Zen tea ceremony.',
            'price' => 185000.00,
            'duration_days' => 6,
            'destination_id' => $kyoto->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 10,
            'available_slots' => 10,
            'start_date' => '2026-10-05',
            'end_date' => '2026-10-11',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Bali Exotic Beaches & Ubud Terraces',
            'description' => 'Unveil the magic of Bali. Relax at private beach clubs in Seminyak, hike the Mount Batur volcano at sunrise, explore Ubud\'s rice terraces, and visit the historic Uluwatu cliff temple.',
            'price' => 75000.00,
            'duration_days' => 6,
            'destination_id' => $bali->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 15,
            'available_slots' => 15,
            'start_date' => '2026-09-20',
            'end_date' => '2026-09-26',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Swiss Alps Express & Jungfraujoch Peak',
            'description' => 'Indulge in unmatched alpine beauty. Ride the scenic Glacier Express, travel to "Top of Europe" at Jungfraujoch, stay in Interlaken chalets, and cruise Lake Thun.',
            'price' => 299999.00,
            'duration_days' => 8,
            'destination_id' => $swissAlps->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 6,
            'available_slots' => 6,
            'start_date' => '2026-08-05',
            'end_date' => '2026-08-13',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Dubai Skyscraper Luxury & Desert Safari',
            'description' => 'Immerse yourself in modern luxury. Access the Burj Khalifa 124th floor, explore Dubai Mall, experience VIP desert dune bashing, and dine in a luxury Bedouin camp under the stars.',
            'price' => 110000.00,
            'duration_days' => 5,
            'destination_id' => $dubai->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 12,
            'available_slots' => 12,
            'start_date' => '2026-11-12',
            'end_date' => '2026-11-17',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Manali Alpine Snow Adventure & Solang Valley Trek',
            'description' => 'Spend a winter wonderland trip in Manali. Enjoy private paragliding in Solang Valley, walk through historical Vashisht temples, and explore Solang snow fields.',
            'price' => 21000.00,
            'duration_days' => 4,
            'destination_id' => $manali->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1605649487212-47bdab064df7?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 15,
            'available_slots' => 15,
            'start_date' => '2026-12-10',
            'end_date' => '2026-12-14',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Varanasi Spiritual Ganges River Ghats & Aarti',
            'description' => 'A unique spiritual retreat. Take a sunrise boat ride on the holy Ganges River, stroll ancient Varanasi lanes, and watch the grand evening Ganga Aarti rituals.',
            'price' => 14500.00,
            'duration_days' => 3,
            'destination_id' => $varanasi->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1561361060-6644fcfc5a45?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 20,
            'available_slots' => 20,
            'start_date' => '2026-10-15',
            'end_date' => '2026-10-18',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'New York Skyscraper Broadway & Central Park Tour',
            'description' => 'Unveil the magic of NYC. Access Top of the Rock observation deck, witness a live Broadway musical, stroll Central Park, and tour the Statue of Liberty.',
            'price' => 185000.00,
            'duration_days' => 6,
            'destination_id' => $newYork->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 8,
            'available_slots' => 8,
            'start_date' => '2026-09-18',
            'end_date' => '2026-09-24',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'Rome Ancient Colosseum & Vatican Heritage Journey',
            'description' => 'Immerse in the Roman Empire. Stroll through the Colosseum, walk the Roman Forum, visit Vatican City St. Peter\'s Basilica, and make a wish at Trevi Fountain.',
            'price' => 139999.00,
            'duration_days' => 5,
            'destination_id' => $rome->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 10,
            'available_slots' => 10,
            'start_date' => '2026-10-12',
            'end_date' => '2026-10-17',
            'status' => 'active'
        ]);

        TourPackage::create([
            'name' => 'London Royal Palaces & Thames Scenic Cruise',
            'description' => 'A royal British holiday. Explore the Tower of London, watch the changing of the guard at Buckingham Palace, and cruise the historic River Thames.',
            'price' => 155000.00,
            'duration_days' => 6,
            'destination_id' => $london->id,
            'tour_manager_id' => $manager->id,
            'image_url' => 'https://images.unsplash.com/photo-1513635269975-59663e0ca1ad?auto=format&fit=crop&w=600&q=80',
            'max_slots' => 12,
            'available_slots' => 12,
            'start_date' => '2026-09-22',
            'end_date' => '2026-09-28',
            'status' => 'active'
        ]);


        // 4. Seed Hotels (managed by Priyanka Sen, prices in Rupees)
        $hotelTaj = Hotel::create([
            'name' => 'The Imperial Agra Palace',
            'description' => 'A heritage palace offering premium suites with private terraces showcasing panoramic views of the Taj Mahal. Experience Michelin-standard Mughlai fine dining.',
            'location' => 'Agra, Uttar Pradesh, India',
            'address' => 'Taj East Gate Road, Agra, 282001',
            'star_rating' => 5,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=600&q=80'
        ]);

        $hotelKerala = Hotel::create([
            'name' => 'Kumarakom Backwater Sanctuary',
            'description' => 'Waterfront luxury villas positioned on the banks of Lake Vembanad. Offers Ayurvedic wellness retreats, private lake boat tours, and natural herbal gardens.',
            'location' => 'Kumarakom, Kottayam, Kerala, India',
            'address' => 'Vembanad Lake Shore, Kumarakom, 686563',
            'star_rating' => 4,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=600&q=80'
        ]);

        $hotelGoa = Hotel::create([
            'name' => 'The Palms Shore Resort',
            'description' => 'Direct beachfront access on clean sands. Features beautiful infinity pools overlooking the Arabian Sea, private cabanas, wellness spas, and vibrant beach shacks.',
            'location' => 'Candolim, Goa, India',
            'address' => 'Candolim Beach Road, North Goa, 403515',
            'star_rating' => 5,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=600&q=80'
        ]);

        // Foreign Hotels
        $hotelParis = Hotel::create([
            'name' => 'Le Parisien Luxury Boutique',
            'description' => 'An elegant Parisian palace hotel featuring classical French styling and balconies overlooking the Eiffel Tower. Features Michelin-starred French fine dining.',
            'location' => 'Paris, France',
            'address' => '15 Avenue Montaigne, Paris, 75008',
            'star_rating' => 5,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=600&q=80'
        ]);

        $hotelKyoto = Hotel::create([
            'name' => 'Kyoto Ryokan Kura',
            'description' => 'A luxury traditional Japanese inn featuring tatami flooring, sliding shoji screens, cypress wood baths, and private zen garden views.',
            'location' => 'Kyoto, Japan',
            'address' => '45 Gionmachi Minamigawa, Kyoto, 605-0074',
            'star_rating' => 5,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1621293954908-907159247fc8?auto=format&fit=crop&w=600&q=80'
        ]);

        $hotelBali = Hotel::create([
            'name' => 'Ubud Hanging Gardens Resort',
            'description' => 'Nestled in deep tropical rainforest cliffs, this hotel boasts world-renowned split-level infinity pools and luxury open-air eco pavilions.',
            'location' => 'Ubud, Bali, Indonesia',
            'address' => 'Desa Buahan, Payangan, Gianyar, Bali, 80572',
            'star_rating' => 5,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=80'
        ]);

        $hotelSwiss = Hotel::create([
            'name' => 'Interlaken Alpine Lodge',
            'description' => 'A premier mountain resort showcasing sweeping panoramas of the Eiger and Jungfrau peaks, outdoor thermal pools, and cozy timber fireplace lounges.',
            'location' => 'Interlaken, Switzerland',
            'address' => 'Höheweg 95, Interlaken, 3800',
            'star_rating' => 4,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1502784444187-359ac186c5bb?auto=format&fit=crop&w=600&q=80'
        ]);

        $hotelDubai = Hotel::create([
            'name' => 'Burj Al Arab Suite Collection',
            'description' => 'Experience absolute luxury. The iconic sail-shaped hotel offers double-story suites, private butler service, underwater restaurants, and private beach access.',
            'location' => 'Dubai, UAE',
            'address' => 'Jumeirah Beach Road, Dubai, 74107',
            'star_rating' => 5,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600&q=80'
        ]);

        $hotelJaipurHaveli = Hotel::create([
            'name' => 'The Raj Heritage Palace & Haveli',
            'description' => 'A restored Rajasthani royal palace featuring grand central courtyards, traditional block-print wall frescoes, traditional puppet shows, and local folk musicians.',
            'location' => 'Jaipur, Rajasthan, India',
            'address' => 'Subhash Chowk, Amer Road, Jaipur, 302002',
            'star_rating' => 5,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=600&q=80'
        ]);

        $hotelVaranasiLodge = Hotel::create([
            'name' => 'Ganges View Heritage Lodge',
            'description' => 'A historic waterfront guest mansion located directly on Varanasi Ghats. Enjoy direct rooftop terrace views of the Ganga river morning rituals.',
            'location' => 'Varanasi, Uttar Pradesh, India',
            'address' => 'Kedar Ghat, Varanasi, 221001',
            'star_rating' => 4,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80'
        ]);

        $hotelManaliCabin = Hotel::create([
            'name' => 'Himalayan Wood Cabin Resort',
            'description' => 'A rustic alpine style lodging featuring pinewood structures, warm fireplace lounges, and balconies showcasing breathtaking snow peaks views.',
            'location' => 'Manali, Himachal Pradesh, India',
            'address' => 'Hadimba Temple Road, Manali, 175131',
            'star_rating' => 4,
            'hotel_partner_id' => $partner->id,
            'image_url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80'
        ]);


        // 5. Seed Hotel Rooms (Prices in Rupees)
        HotelRoom::create([
            'hotel_id' => $hotelTaj->id,
            'room_type' => 'Taj Heritage Balcony Suite',
            'price_per_night' => 12500.00,
            'capacity' => 2,
            'amenities' => ['High-speed WiFi', 'Central Air Conditioning', 'Smart Flat TV', 'King Size Bed', 'Complimentary Minibar', 'Taj Mahal Balcony View', '24/7 Butler Service'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelTaj->id,
            'room_type' => 'Deluxe Garden Room',
            'price_per_night' => 6500.00,
            'capacity' => 2,
            'amenities' => ['High-speed WiFi', 'Air Conditioning', 'Flat TV', 'Twin Beds', 'Tea Maker', 'Palace Garden View'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelKerala->id,
            'room_type' => 'Ayurveda Heritage Cottage',
            'price_per_night' => 8900.00,
            'capacity' => 3,
            'amenities' => ['High-speed WiFi', 'Yukata & Spa Robes', 'Traditional Wooden Decor', 'Ayurveda Herb Set', 'Lake View Balcony', 'Wellness Spa Access'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1602002418082-a4443e081dd1?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelGoa->id,
            'room_type' => 'Palms Ocean Villa with Plunge Pool',
            'price_per_night' => 18000.00,
            'capacity' => 4,
            'amenities' => ['High-speed WiFi', 'Air Conditioning', 'Private Plunge Pool', 'Direct White Sand Beach Access', 'Outdoor Open Bath', 'Mini Kitchenette'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=600&q=80'
        ]);

        // Foreign Hotel Rooms
        HotelRoom::create([
            'hotel_id' => $hotelParis->id,
            'room_type' => 'Eiffel Tower View Executive Suite',
            'price_per_night' => 35000.00,
            'capacity' => 2,
            'amenities' => ['Eiffel Tower View Balcony', 'High-speed WiFi', 'Complimentary Champagne', 'Nespresso Machine', 'Luxury Marble Bath', 'VIP Lounge Access'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1560185007-cde436f6a4d0?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelKyoto->id,
            'room_type' => 'Traditional Tatami Deluxe Suite',
            'price_per_night' => 22000.00,
            'capacity' => 3,
            'amenities' => ['Futon Bedding', 'Private Onsen Bath', 'Zen Garden View', 'Japanese Tea Set', 'Yukata Robes', 'Breakfast Included'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1621293954908-907159247fc8?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelBali->id,
            'room_type' => 'Luxury Pool Panoramic Villa',
            'price_per_night' => 18000.00,
            'capacity' => 2,
            'amenities' => ['Private Infinity Pool', 'Valley Canopy View', 'Outdoor Daybed', 'Mini-bar', 'Open-Air Shower', 'Spa Credits Included'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelSwiss->id,
            'room_type' => 'Eiger Mountain View Suite',
            'price_per_night' => 42000.00,
            'capacity' => 2,
            'amenities' => ['Alpine Balcony View', 'Timber Fireplace', 'Ski Room Storage', 'Complimentary Breakfast buffet', 'Luxury Linens', 'Sauna Entry Passes'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1598928506311-c55ded91a200?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelDubai->id,
            'room_type' => 'Deluxe Marina Panoramic Suite',
            'price_per_night' => 85000.00,
            'capacity' => 4,
            'amenities' => ['24/7 Private Butler', 'Full Sea View Balcony', 'Macallan Whiskey Decanter', 'Private Jacuzzi', 'Gold leaf details', 'Helipad Arrival option'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelJaipurHaveli->id,
            'room_type' => 'Royal Maharaja Courtyard Suite',
            'price_per_night' => 9500.00,
            'capacity' => 2,
            'amenities' => ['King Heritage Bed', 'Courtyard View Balcony', 'Traditional Rajasthani Decor', 'High-speed WiFi', 'Welcome Fruit Platter', 'Central Air Conditioning'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelVaranasiLodge->id,
            'room_type' => 'Ganga River Ghat Balcony Room',
            'price_per_night' => 4500.00,
            'capacity' => 2,
            'amenities' => ['Ganges View Balcony', 'Air Conditioning', 'Free Morning Tea', 'High-speed WiFi', 'Historic Stone Interiors', 'Hot Shower'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80'
        ]);

        HotelRoom::create([
            'hotel_id' => $hotelManaliCabin->id,
            'room_type' => 'Mountain View Pine Wood Room',
            'price_per_night' => 5500.00,
            'capacity' => 3,
            'amenities' => ['Private Fireplace', 'Balcony with Peak Views', 'Pinewood Paneling', 'Cozy Electric Blankets', 'Tea/Coffee Maker', 'Complimentary Breakfast'],
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80'
        ]);


        // 6. Seed Vehicles (Prices in Rupees)
        Vehicle::create([
            'name' => 'Mahindra XUV700',
            'type' => 'SUV (Premium)',
            'price_per_day' => 3500.00,
            'capacity' => 7,
            'provider_name' => 'Bharat Wheels Rentals',
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=600&q=80'
        ]);

        Vehicle::create([
            'name' => 'Force Traveller Luxury',
            'type' => 'Minibus',
            'price_per_day' => 6000.00,
            'capacity' => 15,
            'provider_name' => 'Royal Tour Transports',
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=600&q=80'
        ]);

        Vehicle::create([
            'name' => 'Tata Safari Gold',
            'type' => 'SUV (Premium)',
            'price_per_day' => 4500.00,
            'capacity' => 6,
            'provider_name' => 'Elite Auto Drive India',
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1606016159991-dfe4f2746ad5?auto=format&fit=crop&w=600&q=80'
        ]);

        Vehicle::create([
            'name' => 'BMW 5 Series',
            'type' => 'Sedan (Luxury)',
            'price_per_day' => 12000.00,
            'capacity' => 4,
            'provider_name' => 'Elite Executive Transports',
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=600&q=80'
        ]);

        Vehicle::create([
            'name' => 'Maruti Suzuki Swift',
            'type' => 'Hatchback (Budget)',
            'price_per_day' => 1200.00,
            'capacity' => 5,
            'provider_name' => 'Bharat Wheels Rentals',
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=600&q=80'
        ]);

        Vehicle::create([
            'name' => 'Hyundai i20 Elite',
            'type' => 'Hatchback (Standard)',
            'price_per_day' => 1500.00,
            'capacity' => 5,
            'provider_name' => 'Bharat Wheels Rentals',
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?auto=format&fit=crop&w=600&q=80'
        ]);

        Vehicle::create([
            'name' => 'Honda City ZX',
            'type' => 'Sedan (Standard)',
            'price_per_day' => 2200.00,
            'capacity' => 5,
            'provider_name' => 'Bharat Wheels Rentals',
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=600&q=80'
        ]);

        Vehicle::create([
            'name' => 'Tata Nexon EV',
            'type' => 'SUV (Standard)',
            'price_per_day' => 2000.00,
            'capacity' => 5,
            'provider_name' => 'Bharat Wheels Rentals',
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=600&q=80'
        ]);

        Vehicle::create([
            'name' => 'Toyota Innova Crysta',
            'type' => 'MUV (Premium)',
            'price_per_day' => 3500.00,
            'capacity' => 7,
            'provider_name' => 'Bharat Wheels Rentals',
            'is_available' => true,
            'image_url' => 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=600&q=80'
        ]);
    }
}
