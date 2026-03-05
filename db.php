<?php
$host = 'localhost';
$db   = 'rsoa_rsoa00144_01';
$user = 'rsoa_rsoa00144_01';
$pass = '123456';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Connection failed: " . $e->getMessage());
}

/**
 * Dynamically selects an image URL based on article title keywords and category
 */
function getArticleImage($title, $categoryName = 'news') {
    $titleLower = strtolower($title);
    $categoryLower = strtolower($categoryName);
    
    // Keyword Mapping
    $mappings = [
        // Politics
        'election' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=800&q=80',
        'voting' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=800&q=80',
        'parliament' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=800&q=80',
        'government' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=800&q=80',
        'leaders' => 'https://images.unsplash.com/photo-1523995421752-03e313440cc0?w=800&q=80',
        'policy' => 'https://images.unsplash.com/photo-1523995421752-03e313440cc0?w=800&q=80',
        
        // Technology
        'ai' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&q=80',
        'artificial' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&q=80',
        'software' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&q=80',
        'coding' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&q=80',
        'robotics' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&q=80',
        'automation' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&q=80',
        
        // Business
        'market' => 'https://images.unsplash.com/photo-1611974714851-eb605377a3eb?w=800&q=80',
        'stock' => 'https://images.unsplash.com/photo-1611974714851-eb605377a3eb?w=800&q=80',
        'finance' => 'https://images.unsplash.com/photo-1579532566560-6585f952c792?w=800&q=80',
        'growth' => 'https://images.unsplash.com/photo-1579532566560-6585f952c792?w=800&q=80',
        'company' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80',
        'corporate' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80',
        
        // Entertainment
        'movie' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=800&q=80',
        'film' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=800&q=80',
        'celebrity' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&q=80',
        'carpet' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&q=80',
        'music' => 'https://images.unsplash.com/photo-1514525253344-f814d896261c?w=800&q=80',
        'concert' => 'https://images.unsplash.com/photo-1514525253344-f814d896261c?w=800&q=80',
        
        // Health
        'doctor' => 'https://images.unsplash.com/photo-1505751172107-129658a2d362?w=800&q=80',
        'hospital' => 'https://images.unsplash.com/photo-1505751172107-129658a2d362?w=800&q=80',
        'research' => 'https://images.unsplash.com/photo-1581093458791-9f3c3250bb8b?w=800&q=80',
        'lab' => 'https://images.unsplash.com/photo-1581093458791-9f3c3250bb8b?w=800&q=80',
        'fitness' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800&q=80',
        'gym' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800&q=80',
    ];

    foreach ($mappings as $keyword => $url) {
        if (strpos($titleLower, $keyword) !== false) {
            return $url;
        }
    }

    // Dynamic Fallback using Unsplash Search as requested by USER
    return "https://source.unsplash.com/featured/800x600/?" . urlencode($categoryLower);
}
?>
