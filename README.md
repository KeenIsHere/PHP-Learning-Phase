# 🚀 Core PHP Database Learning Guide

A comprehensive guide to learning PHP with database integration, covering multiple database platforms and real-world professional scenarios. Perfect for beginners who want to master PHP database development! 📚

## 📋 Table of Contents

1. [🔧 Prerequisites](#prerequisites)
2. [📖 PHP Basics Review](#php-basics-review)
3. [🗄️ Database Platforms](#database-platforms)
4. [🔗 Database Connection Methods](#database-connection-methods)
5. [🌍 Real-World Examples](#real-world-examples)
6. [💼 Professional Activities](#professional-activities)
7. [⭐ Best Practices](#best-practices)
8. [🔍 Troubleshooting](#troubleshooting)

## 🔧 Prerequisites

Before diving into PHP database development, make sure you have these essentials ready! 

### 📋 What You Need:
- **PHP 7.4+** installed on your system 💻
- **Basic understanding** of HTML, CSS, and JavaScript 🌐
- **Command line familiarity** (don't worry, we'll guide you!) ⌨️
- **Text editor or IDE** (VS Code, PhpStorm recommended) ✍️

### 🔌 Required PHP Extensions
```bash
# 🔍 Check if extensions are installed
php -m | grep -E "(pdo|mysqli|pgsql|mongodb|sqlite3)"

# 📦 Install missing extensions (Ubuntu/Debian)
sudo apt-get install php-mysql php-pgsql php-mongodb php-sqlite3
```

> 💡 **Beginner Tip**: PHP extensions are like add-ons that give PHP extra capabilities. Think of them as plugins that help PHP talk to different databases!

## 📖 PHP Basics Review

### 🎯 Essential PHP Concepts for Database Work

Let's refresh your PHP knowledge with concepts you'll use constantly in database development:

```php
<?php
// 📝 Variables and Data Types - The building blocks of PHP!
$string = "Hello World";           // 🔍 Check if email already exists in database
    private function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->query($sql, [':email' => $email]);
        return $stmt->fetchColumn() > 0;  // ✅ Return true if email exists
    }
    
    // 📅 Update user's last login timestamp
    private function updateLastLogin($userId) {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = :id";
        $this->db->query($sql, [':id' => $userId]);
    }
}
?>
```

> 🔐 **Security Best Practice**: Always hash passwords with `password_hash()` and verify with `password_verify()`. Never store plain text passwords!

### 3. 📝 Blog Management System

Let's create a professional blogging system with posts, categories, and SEO-friendly URLs!

```php
<?php
// 📁 models/Blog.php
class Blog {
    private $db;  // 🔗 Database connection
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // ✍️ Create new blog post
    public function createPost($data) {
        $sql = "INSERT INTO blog_posts (title, content, author_id, category_id, status, slug) 
                VALUES (:title, :content, :author_id, :category_id, :status, :slug)";
        
        try {
            $slug = $this->generateSlug($data['title']);  // 🔗 Create SEO-friendly URL
            
            $stmt = $this->db->query($sql, [
                ':title' => $data['title'],              // 📰 Post title
                ':content' => $data['content'],          // 📄 Post content
                ':author_id' => $data['author_id'],      // 👤 Who wrote it
                ':category_id' => $data['category_id'],  // 🗂️ Post category
                ':status' => $data['status'] ?? 'draft', // 📊 Published or draft
                ':slug' => $slug                         // 🔗 SEO-friendly URL
            ]);
            
            return $this->db->getConnection()->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("❌ Failed to create blog post: " . $e->getMessage());
        }
    }
    
    // 📖 Get published posts with pagination
    public function getPublishedPosts($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;  // 📄 Calculate pagination offset
        
        // 🔗 JOIN query to get post with author and category info
        $sql = "SELECT bp.*, u.username as author_name, bc.name as category_name 
                FROM blog_posts bp 
                JOIN users u ON bp.author_id = u.id 
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id 
                WHERE bp.status = 'published' 
                ORDER BY bp.published_at DESC 
                LIMIT :limit OFFSET :offset";
        
        try {
            $stmt = $this->db->query($sql, [
                ':limit' => $limit,
                ':offset' => $offset
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("❌ Failed to get blog posts: " . $e->getMessage());
        }
    }
    
    // 🔍 Get single post by SEO slug
    public function getPostBySlug($slug) {
        $sql = "SELECT bp.*, u.username as author_name, u.first_name, u.last_name,
                bc.name as category_name 
                FROM blog_posts bp 
                JOIN users u ON bp.author_id = u.id 
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id 
                WHERE bp.slug = :slug AND bp.status = 'published'";
        
        try {
            $stmt = $this->db->query($sql, [':slug' => $slug]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("❌ Failed to get blog post: " . $e->getMessage());
        }
    }
    
    // 🔗 Generate SEO-friendly URL slug from title
    private function generateSlug($title) {
        // 🔄 Convert title to URL-friendly format
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        
        // 🔍 Make sure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;  // 📝 Add number if slug exists
            $counter++;
        }
        
        return $slug;
    }
    
    // ✅ Check if slug already exists
    private function slugExists($slug) {
        $sql = "SELECT COUNT(*) FROM blog_posts WHERE slug = :slug";
        $stmt = $this->db->query($sql, [':slug' => $slug]);
        return $stmt->fetchColumn() > 0;
    }
}
?>
```

> 🔗 **SEO Tip**: Slugs are URL-friendly versions of titles (like "my-awesome-post" instead of "My Awesome Post!"). They help with search engine optimization!

## 💼 Professional Activities

### 1. 🌐 API Development

Let's build a professional REST API that mobile apps and websites can use!

```php
<?php
// 📁 api/products.php
// 🌐 RESTful API for product management

// 📋 Set proper headers for API response
header('Content-Type: application/json');                    // 📄 Tell client we're sending JSON
header('Access-Control-Allow-Origin: *');                   // 🌍 Allow cross-origin requests
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // 🛠️ Allowed HTTP methods
header('Access-Control-Allow-Headers: Content-Type');       // 📋 Allowed headers

require_once '../config/database.php';
require_once '../models/Product.php';

try {
    // 🔗 Get database connection
    $database = DatabaseManager::getInstance()->getConnection('mysql');
    $product = new Product($database);
    
    // 🛠️ Get HTTP method (GET, POST, PUT, DELETE)
    $method = $_SERVER['REQUEST_METHOD'];
    
    // 📥 Get JSON input data
    $input = json_decode(file_get_contents('php://input'), true);
    
    // 🎯 Handle different HTTP methods
    switch ($method) {
        case 'GET':  // 🔍 Read operations
            if (isset($_GET['id'])) {
                // 📖 Get single product by ID
                $result = $product->findById($_GET['id']);
            } else {
                // 📊 Get multiple products with filters
                $filters = [
                    'category_id' => $_GET['category_id'] ?? null,  // 🗂️ Filter by category
                    'min_price' => $_GET['min_price'] ?? null,      // 💰 Minimum price
                    'max_price' => $_GET['max_price'] ?? null       // 💰 Maximum price
                ];
                $page = $_GET['page'] ?? 1;        // 📄 Page number
                $limit = $_GET['limit'] ?? 10;     // 📊 Results per page
                
                $result = $product->getProducts($filters, $page, $limit);
            }
            break;
            
        case 'POST':  // ➕ Create new product
            $result = $product->create($input);
            break;
            
        case 'PUT':   // ✏️ Update existing product
            if (!isset($_GET['id'])) {
                throw new Exception('❌ Product ID is required for update');
            }
            $result = $product->update($_GET['id'], $input);
            break;
            
        case 'DELETE':  // 🗑️ Delete product
            if (!isset($_GET['id'])) {
                throw new Exception('❌ Product ID is required for delete');
            }
            $result = $product->delete($_GET['id']);
            break;
            
        default:
            throw new Exception('❌ Method not allowed');
    }
    
    // ✅ Success response
    echo json_encode([
        'success' => true,
        'data' => $result,
        'timestamp' => date('Y-m-d H:i:s')  // 📅 When response was generated
    ]);
    
} catch (Exception $e) {
    // ❌ Error response
    http_response_code(400);  // 📊 Set HTTP error status
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}
?>
```

> 🌐 **API Best Practice**: Always return consistent JSON responses with success/error status and meaningful error messages!

### 2. 🔄 Data Migration Scripts

Sometimes you need to move data between different databases or systems. Here's how professionals do it:

```php
<?php
// 📁 scripts/migrate_data.php
require_once '../config/database.php';

// 🚚 Professional data migration class
class DataMigration {
    private $sourceDb;     // 📤 Where data comes from
    private $targetDb;     // 📥 Where data goes to
    
    public function __construct($sourceType, $targetType) {
        $dbManager = DatabaseManager::getInstance();
        $this->sourceDb = $dbManager->getConnection($sourceType);
        $this->targetDb = $dbManager->getConnection($targetType);
    }
    
    // 👥 Migrate users from one database to another
    public function migrateUsers() {
        echo "🚀 Starting user migration...\n";
        
        // 📤 Get all users from source database
        $sourceUsers = $this->sourceDb->query("SELECT * FROM users")->fetchAll();
        
        $migrated = 0;  // ✅ Count successful migrations
        $errors = 0;    // ❌ Count errors
        
        // 🔄 Process each user
        foreach ($sourceUsers as $user) {
            try {
                // 📥 Insert into target database
                $this->targetDb->query(
                    "INSERT INTO users (id, username, email, password_hash, first_name, last_name, created_at) 
                     VALUES (:id, :username, :email, :password_hash, :first_name, :last_name, :created_at)",
                    [
                        ':id' => $user['id'],
                        ':username' => $user['username'],
                        ':email' => $user['email'],
                        ':password_hash' => $user['password_hash'],
                        ':first_name' => $user['first_name'],
                        ':last_name' => $user['last_name'],
                        ':created_at' => $user['created_at']
                    ]
                );
                $migrated++;
                echo "✅ Migrated user: {$user['username']}\n";
            } catch (Exception $e) {
                echo "❌ Error migrating user {$user['id']}: " . $e->getMessage() . "\n";
                $errors++;
            }
        }
        
        echo "🎉 Migration completed. Migrated: $migrated, Errors: $errors\n";
    }
    
    // 🔄 Migrate with progress tracking
    public function migrateWithProgress($tableName, $batchSize = 100) {
        echo "🚀 Starting migration of table: $tableName\n";
        
        // 📊 Get total count for progress tracking
        $totalStmt = $this->sourceDb->query("SELECT COUNT(*) FROM $tableName");
        $total = $totalStmt->fetchColumn();
        
        echo "📊 Total records to migrate: $total\n";
        
        $offset = 0;
        $migrated = 0;
        
        while ($offset < $total) {
            // 📦 Get batch of records
            $stmt = $this->sourceDb->query(
                "SELECT * FROM $tableName LIMIT :limit OFFSET :offset",
                [':limit' => $batchSize, ':offset' => $offset]
            );
            $batch = $stmt->fetchAll();
            
            foreach ($batch as $record) {
                // 🔄 Process each record (customize based on your needs)
                $this->migrateSingleRecord($tableName, $record);
                $migrated++;
            }
            
            $offset += $batchSize;
            $progress = round(($migrated / $total) * 100, 2);
            echo "📈 Progress: {$progress}% ({$migrated}/{$total})\n";
        }
        
        echo "🎉 Migration completed successfully!\n";
    }
    
    // 📝 Migrate single record (customize this method)
    private function migrateSingleRecord($tableName, $record) {
        // 🏗️ Build dynamic INSERT query
        $columns = array_keys($record);
        $placeholders = ':' . implode(', :', $columns);
        $columnList = implode(', ', $columns);
        
        $sql = "INSERT INTO $tableName ($columnList) VALUES ($placeholders)";
        
        // 🔧 Prepare parameters
        $params = [];
        foreach ($record as $key => $value) {
            $params[":$key"] = $value;
        }
        
        $this->targetDb->query($sql, $params);
    }
}

// 📖 Usage Examples
try {
    // 🔄 Migrate from MySQL to PostgreSQL
    $migration = new DataMigration('mysql', 'postgresql');
    
    // 👥 Migrate users
    $migration->migrateUsers();
    
    // 📦 Migrate products with progress tracking
    $migration->migrateWithProgress('products', 50);
    
} catch (Exception $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
}
?>
```

> 🚚 **Migration Tip**: Always test migrations on a copy of your data first! Batch processing prevents memory issues with large datasets.

### 3. 💾 Database Backup and Restore

Protecting your data is crucial! Here's how to create professional backup systems:

```php
<?php
// 📁 scripts/backup_restore.php
class DatabaseBackup {
    private $db;  // 🔗 Database connection
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // 💾 Backup database tables to JSON file
    public function backupToJson($tables, $filename) {
        $backup = [];  // 📦 Store all table data
        
        foreach ($tables as $table) {
            echo "📤 Backing up table: $table\n";
            
            try {
                // 📊 Get all data from table
                $stmt = $this->db->query("SELECT * FROM $table");
                $backup[$table] = $stmt->fetchAll();
                
                echo "✅ Backed up " . count($backup[$table]) . " records from $table\n";
            } catch (Exception $e) {
                echo "❌ Error backing up $table: " . $e->getMessage() . "\n";
                continue;  // Skip this table and continue with others
            }
        }
        
        // 💾 Save backup to file
        $json = json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        // 📁 Create backup directory if it doesn't exist
        $backupDir = dirname($filename);
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        
        // ✍️ Write backup file
        if (file_put_contents($filename, $json)) {
            echo "🎉 Backup completed successfully: $filename\n";
            echo "📊 File size: " . $this->formatBytes(filesize($filename)) . "\n";
        } else {
            throw new Exception("❌ Failed to write backup file");
        }
    }
    
    // 📥 Restore database from JSON backup
    public function restoreFromJson($filename) {
        if (!file_exists($filename)) {
            throw new Exception("❌ Backup file not found: $filename");
        }
        
        echo "📥 Starting restore from: $filename\n";
        
        // 📖 Read backup file
        $backupContent = file_get_contents($filename);
        $backup = json_decode($backupContent, true);
        
        if ($backup === null) {
            throw new Exception("❌ Invalid backup file format");
        }
        
        // 🔄 Restore each table
        foreach ($backup as $table => $rows) {
            echo "📥 Restoring table: $table\n";
            
            if (empty($rows)) {
                echo "⚠️ No data to restore for table: $table\n";
                continue;
            }
            
            try {
                // 🏗️ Build dynamic INSERT query
                $columns = array_keys($rows[0]);
                $placeholders = ':' . implode(', :', $columns);
                $columnList = implode(', ', $columns);
                
                $sql = "INSERT INTO $table ($columnList) VALUES ($placeholders)";
                
                $restoredCount = 0;
                
                // 📝 Insert each row
                foreach ($rows as $row) {
                    $params = [];
                    foreach ($columns as $column) {
                        $params[":$column"] = $row[$column];
                    }
                    
                    $this->db->query($sql, $params);
                    $restoredCount++;
                }
                
                echo "✅ Restored $restoredCount records to $table\n";
                
            } catch (Exception $e) {
                echo "❌ Error restoring $table: " . $e->getMessage() . "\n";
            }
        }
        
        echo "🎉 Restore completed!\n";
    }
    
    // 🗜️ Create compressed backup
    public function backupToCompressedJson($tables, $filename) {
        // 💾 Create regular backup first
        $tempFile = $filename . '.tmp';
        $this->backupToJson($tables, $tempFile);
        
        // 🗜️ Compress the backup
        $data = file_get_contents($tempFile);
        $compressed = gzcompress($data, 9);  // Maximum compression
        
        // 💾 Save compressed file
        file_put_contents($filename . '.gz', $compressed);
        
        // 🧹 Clean up temporary file
        unlink($tempFile);
        
        echo "🗜️ Compressed backup created: " . $filename . '.gz' . "\n";
        echo "📊 Original size: " . $this->formatBytes(strlen($data)) . "\n";
        echo "📊 Compressed size: " . $this->formatBytes(strlen($compressed)) . "\n";
        echo "📈 Compression ratio: " . round((1 - strlen($compressed) / strlen($data)) * 100, 1) . "%\n";
    }
    
    // 📏 Format file size in human readable format
    private function formatBytes($size, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
    
    // 🔄 Automated backup with rotation
    public function createAutomatedBackup($tables, $backupDir = 'backups', $keepDays = 7) {
        // 📅 Create filename with timestamp
        $timestamp = date('Y-m-d_H-i-s');
        $filename = "$backupDir/backup_$timestamp.json";
        
        // 💾 Create backup
        $this->backupToJson($tables, $filename);
        
        // 🧹 Clean up old backups
        $this->cleanupOldBackups($backupDir, $keepDays);
        
        return $filename;
    }
    
    // 🧹 Remove old backup files
    private function cleanupOldBackups($backupDir, $keepDays) {
        if (!is_dir($backupDir)) return;
        
        $cutoffTime = time() - ($keepDays * 24 * 60 * 60);  // ⏰ Calculate cutoff time
        $files = glob("$backupDir/backup_*.json*");         // 🔍 Find backup files
        
        foreach ($files as $file) {
            if (filemtime($file) < $cutoffTime) {            // 🗓️ Check if file is old
                if (unlink($file)) {                          // 🗑️ Delete old file
                    echo "🧹 Cleaned up old backup: " . basename($file) . "\n";
                }
            }
        }
    }
}

// 📖 Usage Examples
try {
    // 🔗 Get database connection
    $database = DatabaseManager::getInstance()->getConnection('mysql');
    $backup = new DatabaseBackup($database);
    
    // 📋 Tables to backup
    $tables = ['users', 'products', 'orders', 'categories'];
    
    // 💾 Create regular backup
    $backupFile = $backup->createAutomatedBackup($tables);
    echo "📁 Backup saved to: $backupFile\n";
    
    // 🗜️ Create compressed backup
    $backup->backupToCompressedJson($tables, 'backups/compressed_backup_' . date('Y-m-d'));
    
    // 📥 Restore from backup (uncomment to use)
    // $backup->restoreFromJson('backups/backup_2023-12-01_10-30-00.json');
    
} catch (Exception $e) {
    echo "❌ Backup operation failed: " . $e->getMessage() . "\n";
}
?>
```

> 💡 **Backup Strategy**: The 3-2-1 rule - Keep 3 copies of important data, on 2 different media types, with 1 copy offsite!

## ⭐ Best Practices

### 1. 🛡️ Security Best Practices

Security is not optional in professional development! Here are the essential practices:

```php
<?php
// 🔐 Security implementation examples

// 1. 🛡️ Prepared Statements (ALWAYS use these!)
function getUser($id) {
    global $pdo;
    // ✅ GOOD: Using prepared statement
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
    
    // ❌ BAD: Direct string concatenation (SQL injection risk!)
    // $query = "SELECT * FROM users WHERE id = " . $id;  // NEVER DO THIS!
}

// 2. ✅ Input Validation and Sanitization
function validateAndSanitizeInput($data) {
    $clean = [];  // 📦 Store cleaned data
    
    // 📧 Email validation and sanitization
    $clean['email'] = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
    
    // ✅ Validate email format
    if (!filter_var($clean['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("❌ Invalid email format");
    }
    
    // 📝 Sanitize string inputs (prevent XSS attacks)
    $clean['name'] = htmlspecialchars(trim($data['name']), ENT_QUOTES, 'UTF-8');
    
    // 🔢 Validate and sanitize numeric inputs
    $clean['age'] = filter_var($data['age'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 120]  // Reasonable age limits
    ]);
    
    if ($clean['age'] === false) {
        throw new Exception("❌ Invalid age (must be between 1 and 120)");
    }
    
    return $clean;
}

// 3. 🔐 Advanced Password Security
function securePassword($password) {
    // 📏 Minimum length requirement
    if (strlen($password) < 8) {
        throw new Exception("❌ Password must be at least 8 characters long");
    }
    
    // 🔠 Uppercase letter requirement
    if (!preg_match('/[A-Z]/', $password)) {
        throw new Exception("❌ Password must contain at least one uppercase letter");
    }
    
    // 🔡 Lowercase letter requirement
    if (!preg_match('/[a-z]/', $password)) {
        throw new Exception("❌ Password must contain at least one lowercase letter");
    }
    
    // 🔢 Number requirement
    if (!preg_match('/[0-9]/', $password)) {
        throw new Exception("❌ Password must contain at least one number");
    }
    
    // 🔣 Special character requirement
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        throw new Exception("❌ Password must contain at least one special character");
    }
    
    // 🔐 Hash with strongest available algorithm
    return password_hash($password, PASSWORD_ARGON2ID, [
        'memory_cost' => 65536,  // 64 MB memory usage
        'time_cost' => 4,        // 4 iterations
        'threads' => 3           // 3 parallel threads
    ]);
}

// 4. 🛡️ CSRF Protection (Cross-Site Request Forgery)
function generateCSRFToken() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();  // 🚀 Start session if not already started
    }
    
    if (!isset($_SESSION['csrf_token'])) {
        // 🎲 Generate cryptographically secure random token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // 🔐 Use hash_equals to prevent timing attacks
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// 📝 Example: Using CSRF in forms
echo '<form method="POST">';
echo '<input type="hidden" name="csrf_token" value="' . generateCSRFToken() . '">';
echo '<input type="text" name="username" placeholder="Username">';
echo '<button type="submit">Submit</button>';
echo '</form>';

// 🔍 Example: Validating CSRF on form submission
if ($_POST) {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        die('❌ Invalid CSRF token. Possible security attack prevented!');
    }
    // ✅ Process form safely...
}

// 5. 🚦 Rate Limiting (Prevent abuse)
class RateLimiter {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // 🕰️ Check if user has exceeded rate limit
    public function checkLimit($identifier, $maxAttempts = 5, $timeWindow = 3600) {
        // 📊 Count attempts in time window
        $sql = "SELECT COUNT(*) FROM rate_limits 
                WHERE identifier = :identifier 
                AND created_at > DATE_SUB(NOW(), INTERVAL :timeWindow SECOND)";
        
        $stmt = $this->db->query($sql, [
            ':identifier' => $identifier,  // Could be IP address, user ID, etc.
            ':timeWindow' => $timeWindow   // Time window in seconds (3600 = 1 hour)
        ]);
        
        $attempts = $stmt->fetchColumn();
        
        // 🚫 Block if too many attempts
        if ($attempts >= $maxAttempts) {
            throw new Exception("🚦 Rate limit exceeded. Try again later.");
        }
        
        // 📝 Log this attempt
        $this->logAttempt($identifier);
        
        return true;  // ✅ Request allowed
    }
    
    // 📝 Log rate limit attempt
    private function logAttempt($identifier) {
        $sql = "INSERT INTO rate_limits (identifier, created_at) VALUES (:identifier, NOW())";
        $this->db->query($sql, [':identifier' => $identifier]);
    }
    
    // 🧹 Clean up old rate limit records
    public function cleanup($olderThanHours = 24) {
        $sql = "DELETE FROM rate_limits WHERE created_at < DATE_SUB(NOW(), INTERVAL :hours HOUR)";
        $stmt = $this->db->query($sql, [':hours' => $olderThanHours]);
        return $stmt->rowCount();  // Return number of deleted records
    }
}

// 📖 Usage example
try {
    $rateLimiter = new RateLimiter($database);
    $userIP = $_SERVER['REMOTE_ADDR'];  // 🌐 Get user's IP address
    
    // 🔍 Check rate limit before processing login
    $rateLimiter->checkLimit($userIP, 5, 900);  // 5 attempts per 15 minutes
    
    // ✅ Process login if rate limit passed...
    
} catch (Exception $e) {
    echo "🚫 " . $e->getMessage();
}
?>
```

> 🛡️ **Security Mindset**: Always assume user input is malicious and validate everything! Security is about layers of protection, not just one solution.

### 2. 🚀 Performance Optimization

Making your applications fast and efficient is crucial for user experience and server costs!

```php
<?php
// 🚀 Performance optimization examples

// 1. 🏊‍♂️ Database Connection Pooling
class ConnectionPool {
    private static $pool = [];           // 🔗 Store active connections
    private static $maxConnections = 10; // 📊 Maximum connections allowed
    private static $activeConnections = 0; // 📈 Current active connections
    
    public static function getConnection($config) {
        if (self::$activeConnections < self::$maxConnections) {
            // 🆕 Create new connection if under limit
            $connection = new PDO($config['dsn'], $config['username'], $config['password']);
            self::$pool[] = $connection;
            self::$activeConnections++;
            echo "🆕 Created new database connection (Total: " . self::$activeConnections . ")\n";
            return $connection;
        }
        
        // ♻️ Reuse existing connection if at limit
        $connection = self::$pool[array_rand(self::$pool)];
        echo "♻️ Reusing existing database connection\n";
        return $connection;
    }
    
    // 🧹 Clean up connections when done
    public static function closeAll() {
        self::$pool = [];
        self::$activeConnections = 0;
        echo "🧹 All database connections closed\n";
    }
}

// 2. 💾 Query Caching System
class QueryCache {
    private $cache = [];              // 📦 In-memory cache storage
    private $maxCacheSize = 100;      // 📊 Maximum cached items
    private $hitCount = 0;            // 📈 Cache hits counter
    private $missCount = 0;           // 📉 Cache misses counter
    
    // 🔍 Get cached query result
    public function get($key) {
        if (isset($this->cache[$key])) {
            // ✅ Check if cache entry is still valid
            if (!$this->isExpired($key)) {
                $this->hitCount++;
                echo "🎯 Cache HIT for key: $key\n";
                return $this->cache[$key]['data'];
            } else {
                // 🗑️ Remove expired entry
                unset($this->cache[$key]);
            }
        }
        
        $this->missCount++;
        echo "❌ Cache MISS for key: $key\n";
        return null;
    }
    
    // 💾 Store query result in cache
    public function set($key, $value, $ttl = 3600) {
        // 🧹 Clean cache if it's getting too large
        if (count($this->cache) >= $this->maxCacheSize) {
            $this->evictOldest();  // Remove oldest entry
        }
        
        $this->cache[$key] = [
            'data' => $value,
            'expires' => time() + $ttl,      // ⏰ Expiration timestamp
            'created' => time()              // 📅 Creation timestamp
        ];
        
        echo "💾 Cached result for key: $key (TTL: {$ttl}s)\n";
    }
    
    // ⏰ Check if cache entry has expired
    public function isExpired($key) {
        return isset($this->cache[$key]) && $this->cache[$key]['expires'] < time();
    }
    
    // 🧹 Remove oldest cache entry (LRU - Least Recently Used)
    private function evictOldest() {
        if (empty($this->cache)) return;
        
        $oldest = null;
        $oldestTime = PHP_INT_MAX;
        
        foreach ($this->cache as $key => $entry) {
            if ($entry['created'] < $oldestTime) {
                $oldestTime = $entry['created'];
                $oldest = $key;
            }
        }
        
        if ($oldest) {
            unset($this->cache[$oldest]);
            echo "🗑️ Evicted oldest cache entry: $oldest\n";
        }
    }
    
    // 📊 Get cache statistics
    public function getStats() {
        $total = $this->hitCount + $this->missCount;
        $hitRate = $total > 0 ? round(($this->hitCount / $total) * 100, 2) : 0;
        
        return [
            'hits' => $this->hitCount,
            'misses' => $this->missCount,
            'hit_rate' => $hitRate . '%',
            'cached_items' => count($this->cache)
        ];
    }
}

// 📖 Usage example with caching
class CachedProductService {
    private $db;
    private $cache;
    
    public function __construct($database) {
        $this->db = $database;
        $this->cache = new QueryCache();
    }
    
    // 🔍 Get product with caching
    public function getProduct($id) {
        $cacheKey = "product_$id";
        
        // 🎯 Try to get from cache first
        $cached = $this->cache->get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }
        
        // 🗄️ Get from database if not cached
        $stmt = $this->db->query("SELECT * FROM products WHERE id = ?", [$id]);
        $product = $stmt->fetch();
        
        // 💾 Store in cache for 30 minutes
        if ($product) {
            $this->cache->set($cacheKey, $product, 1800);
        }
        
        return $product;
    }
}

// 3. 📦 Batch Operations for Better Performance
class BatchProcessor {
    private $db;
    private $batchSize;
    
    public function __construct($database, $batchSize = 1000) {
        $this->db = $database;
        $this->batchSize = $batchSize;
    }
    
    // 📦 Insert multiple records efficiently
    public function batchInsert($table, $data, $columns) {
        if (empty($data)) {
            echo "⚠️ No data to insert\n";
            return;
        }
        
        // 📊 Split data into batches
        $batches = array_chunk($data, $this->batchSize);
        $totalInserted = 0;
        
        foreach ($batches as $batchIndex => $batch) {
            echo "📦 Processing batch " . ($batchIndex + 1) . "/" . count($batches) . "\n";
            
            $placeholders = [];
            $values = [];
            
            // 🏗️ Build batch INSERT query
            foreach ($batch as $rowIndex => $row) {
                $rowPlaceholders = [];
                foreach ($columns as $column) {
                    $placeholder = ":${column}_${rowIndex}";
                    $rowPlaceholders[] = $placeholder;
                    $values[$placeholder] = $row[$column];
                }
                $placeholders[] = '(' . implode(', ', $rowPlaceholders) . ')';
            }
            
            // 🚀 Execute batch insert
            $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES " . implode(', ', $placeholders);
            
            try {
                $this->db->query($sql, $values);
                $inserted = count($batch);
                $totalInserted += $inserted;
                echo "✅ Inserted $inserted records in batch\n";
            } catch (Exception $e) {
                echo "❌ Batch insert failed: " . $e->getMessage() . "\n";
            }
        }
        
        echo "🎉 Total inserted: $totalInserted records\n";
    }
    
    // 🔄 Update multiple records efficiently
    public function batchUpdate($table, $updates, $keyColumn = 'id') {
        if (empty($updates)) {
            echo "⚠️ No updates to process\n";
            return;
        }
        
        $batches = array_chunk($updates, $this->batchSize);
        $totalUpdated = 0;
        
        foreach ($batches as $batchIndex => $batch) {
            echo "🔄 Processing update batch " . ($batchIndex + 1) . "/" . count($batches) . "\n";
            
            // 🏗️ Build CASE statements for bulk update
            $setClauses = [];
            $ids = [];
            $allValues = [];
            
            // Get all columns to update (from first record)
            $columns = array_keys($batch[0]);
            $columns = array_filter($columns, function($col) use ($keyColumn) {
                return $col !== $keyColumn;  // Exclude key column
            });
            
            foreach ($columns as $column) {
                $caseStatements = [];
                foreach ($batch as $rowIndex => $row) {
                    $placeholder = ":${column}_${rowIndex}";
                    $idPlaceholder = ":id_${rowIndex}";
                    $caseStatements[] = "WHEN $keyColumn = $idPlaceholder THEN $placeholder";
                    $allValues[$placeholder] = $row[$column];
                    $allValues[$idPlaceholder] = $row[$keyColumn];
                }
                $setClauses[] = "$column = CASE " . implode(' ', $caseStatements) . " END";
            }
            
            // 📝 Collect all IDs for WHERE clause
            foreach ($batch as $rowIndex => $row) {
                $ids[] = ":where_id_$rowIndex";
                $allValues[":where_id_$rowIndex"] = $row[$keyColumn];
            }
            
            // 🚀 Execute batch update
            $sql = "UPDATE $table SET " . implode(', ', $setClauses) . 
                   " WHERE $keyColumn IN (" . implode(', ', $ids) . ")";
            
            try {
                $stmt = $this->db->query($sql, $allValues);
                $updated = $stmt->rowCount();
                $totalUpdated += $updated;
                echo "✅ Updated $updated records in batch\n";
            } catch (Exception $e) {
                echo "❌ Batch update failed: " . $e->getMessage() . "\n";
            }
        }
        
        echo "🎉 Total updated: $totalUpdated records\n";
    }
}

// 4. 📊 Database Indexing Helper
class IndexManager {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // 🚀 Create database index for better performance
    public function createIndex($table, $columns, $indexName = null) {
        $indexName = $indexName ?: 'idx_' . implode('_', $columns);
        $columnList = implode(', ', $columns);
        
        $sql = "CREATE INDEX $indexName ON $table ($columnList)";
        
        try {
            $this->db->query($sql);
            echo "🚀 Index '$indexName' created successfully on $table($columnList)\n";
        } catch (Exception $e) {
            echo "❌ Failed to create index '$indexName': " . $e->getMessage() . "\n";
        }
    }
    
    // 🔍 Analyze query performance
    public function analyzeQueryPerformance($sql, $params = []) {
        // 📊 Add EXPLAIN to analyze query execution plan
        $explainSql = "EXPLAIN " . $sql;
        
        try {
            $stmt = $this->db->query($explainSql, $params);
            $result = $stmt->fetchAll();
            
            echo "📊 Query Performance Analysis:\n";
            echo "📝 Query: $sql\n";
            echo "📈 Execution Plan:\n";
            
            foreach ($result as $row) {
                echo "  🔍 Table: {$row['table']}, Type: {$row['type']}, Rows: {$row['rows']}\n";
                if (isset($row['Extra'])) {
                    echo "      📋 Extra: {$row['Extra']}\n";
                }
            }
            
            return $result;
        } catch (Exception $e) {
            echo "❌ Failed to analyze query: " . $e->getMessage() . "\n";
            return null;
        }
    }
    
    // 📊 Suggest indexes based on slow queries
    public function suggestIndexes($slowQueries) {
        echo "💡 Index Suggestions:\n";
        
        foreach ($slowQueries as $query) {
            // 🔍 Simple analysis - look for WHERE clauses
            if (preg_match_all('/WHERE\s+(\w+\.\w+|\w+)\s*[=<>]/', $query, $matches)) {
                $columns = $matches[1];
                foreach ($columns as $column) {
                    echo "  🚀 Consider adding index on: $column\n";
                }
            }
            
            // 🔗 Look for JOIN conditions
            if (preg_match_all('/JOIN\s+\w+\s+\w+\s+ON\s+(\w+\.\w+|\w+)\s*=\s*(\w+\.\w+|\w+)/', $query, $matches)) {
                for ($i = 0; $i < count($matches[1]); $i++) {
                    echo "  🔗 Consider adding index on JOIN columns: {$matches[1][$i]}, {$matches[2][$i]}\n";
                }
            }
            
            // 📊 Look for ORDER BY clauses
            if (preg_match_all('/ORDER\s+BY\s+(\w+\.\w+|\w+)/', $query, $matches)) {
                $columns = $matches[1];
                foreach ($columns as $column) {
                    echo "  📈 Consider adding index on ORDER BY column: $column\n";
                }
            }
        }
    }
}

// 📖 Usage Examples
try {
    // 🔗 Get database connection
    $database = DatabaseManager::getInstance()->getConnection('mysql');
    
    // 📊 Test caching system
    $productService = new CachedProductService($database);
    $product1 = $productService->getProduct(1);  // Database hit
    $product2 = $productService->getProduct(1);  // Cache hit
    
    // 📦 Test batch operations
    $batchProcessor = new BatchProcessor($database, 500);
    
    // Sample data for batch insert
    $sampleProducts = [];
    for ($i = 1; $i <= 1000; $i++) {
        $sampleProducts[] = [
            'name' => "Product $i",
            'description' => "Description for product $i",
            'price' => rand(10, 1000),
            'stock_quantity' => rand(0, 100),
            'category_id' => rand(1, 5)
        ];
    }
    
    // 🚀 Batch insert (much faster than individual inserts)
    $batchProcessor->batchInsert('products', $sampleProducts, ['name', 'description', 'price', 'stock_quantity', 'category_id']);
    
    // 📊 Create performance indexes
    $indexManager = new IndexManager($database);
    $indexManager->createIndex('products', ['category_id', 'price'], 'idx_category_price');
    $indexManager->createIndex('products', ['name'], 'idx_product_name');
    
    // 🔍 Analyze query performance
    $indexManager->analyzeQueryPerformance(
        "SELECT * FROM products WHERE category_id = ? AND price BETWEEN ? AND ? ORDER BY name",
        [1, 10, 100]
    );
    
} catch (Exception $e) {
    echo "❌ Performance optimization failed: " . $e->getMessage() . "\n";
}
?>
```

> 🚀 **Performance Tips**: 
> - **Indexes** are like book bookmarks - they help find data quickly
> - **Caching** stores frequently used data in memory
> - **Batch operations** process multiple records at once instead of one-by-one
> - **Connection pooling** reuses database connections instead of creating new ones

### 3. 📝 Error Handling and Logging

Professional applications need robust error handling and logging for debugging and monitoring!

```php
<?php
// 📝 Professional error handling and logging system

// 1. 🏷️ Custom Exception Classes for Different Error Types
class DatabaseException extends Exception {
    protected $query;     // 📝 SQL query that failed
    protected $params;    // 📋 Parameters used in query
    
    public function __construct($message, $query = '', $params = [], $code = 0, Exception $previous = null) {
        $this->query = $query;
        $this->params = $params;
        parent::__construct($message, $code, $previous);
    }
    
    // 📤 Get the SQL query that caused the error
    public function getQuery() {
        return $this->query;
    }
    
    // 📤 Get the parameters used in the query
    public function getParams() {
        return $this->params;
    }
    
    // 📋 Get detailed error information
    public function getDetailedInfo() {
        return [
            'message' => $this->getMessage(),
            'query' => $this->query,
            'params' => $this->params,
            'file' => $this->getFile(),
            'line' => $this->getLine()
        ];
    }
}

class ValidationException extends Exception {
    private $field;       // 🏷️ Field that failed validation
    private $value;       // 📝 Value that was invalid
    
    public function __construct($message, $field = '', $value = '', $code = 0, Exception $previous = null) {
        $this->field = $field;
        $this->value = $value;
        parent::__construct($message, $code, $previous);
    }
    
    public function getField() { return $this->field; }
    public function getValue() { return $this->value; }
}

class AuthenticationException extends Exception {}
class AuthorizationException extends Exception {}
class RateLimitException extends Exception {}

// 2. 📊 Professional Logging System
class Logger {
    private $logFile;         // 📁 Log file path
    private $logLevel;        // 📊 Minimum log level to record
    private $maxFileSize;     // 📏 Maximum log file size before rotation
    
    // 🎯 Log levels (higher number = more severe)
    const DEBUG = 1;      // 🐛 Detailed debugging information
    const INFO = 2;       // ℹ️ General information
    const WARNING = 3;    // ⚠️ Warning conditions
    const ERROR = 4;      // ❌ Error conditions
    const CRITICAL = 5;   // 🚨 Critical conditions
    
    public function __construct($logFile = 'logs/app.log', $logLevel = self::INFO, $maxFileSize = 10485760) {
        $this->logFile = $logFile;
        $this->logLevel = $logLevel;
        $this->maxFileSize = $maxFileSize; // 10MB default
        
        // 📁 Create log directory if it doesn't exist
        $logDir = dirname($this->logFile);
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
            echo "📁 Created log directory: $logDir\n";
        }
    }
    
    // 📝 Main logging method
    public function log($level, $message, $context = []) {
        // 🚫 Skip if below minimum log level
        if ($level < $this->logLevel) {
            return;
        }
        
        // 🔄 Rotate log file if it's too large
        $this->rotateLogIfNeeded();
        
        // 🏷️ Map level numbers to names
        $levelNames = [
            self::DEBUG => 'DEBUG',
            self::INFO => 'INFO',
            self::WARNING => 'WARNING',
            self::ERROR => 'ERROR',
            self::CRITICAL => 'CRITICAL'
        ];
        
        // 📅 Build log entry
        $timestamp = date('Y-m-d H:i:s');
        $levelName = $levelNames[$level] ?? 'UNKNOWN';
        $pid = getmypid();  // 🆔 Process ID for debugging
        
        // 📋 Add context information if provided
        $contextStr = '';
        if (!empty($context)) {
            $contextStr = ' | Context: ' . json_encode($context, JSON_UNESCAPED_UNICODE);
        }
        
        // 🔍 Add memory usage for performance monitoring
        $memoryUsage = round(memory_get_usage() / 1024 / 1024, 2); // MB
        
        $logEntry = "[$timestamp] [$levelName] [PID:$pid] [MEM:{$memoryUsage}MB] $message$contextStr" . PHP_EOL;
        
        // ✍️ Write to log file
        if (file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX) === false) {
            error_log("Failed to write to log file: {$this->logFile}");
        }
    }
    
    // 🔄 Rotate log file if it gets too large
    private function rotateLogIfNeeded() {
        if (!file_exists($this->logFile)) {
            return;
        }
        
        if (filesize($this->logFile) > $this->maxFileSize) {
            $timestamp = date('Y-m-d_H-i-s');
            $rotatedFile = $this->logFile . '.' . $timestamp;
            
            if (rename($this->logFile, $rotatedFile)) {
                $this->info("Log file rotated", ['old_file' => $rotatedFile, 'new_file' => $this->logFile]);
            }
        }
    }
    
    // 🎯 Convenience methods for different log levels
    public function debug($message, $context = []) {
        $this->log(self::DEBUG, $message, $context);
    }
    
    public function info($message, $context = []) {
        $this->log(self::INFO, $message, $context);
    }
    
    public function warning($message, $context = []) {
        $this->log(self::WARNING, $message, $context);
    }
    
    public function error($message, $context = []) {
        $this->log(self::ERROR, $message, $context);
    }
    
    public function critical($message, $context = []) {
        $this->log(self::CRITICAL, $message, $context);
    }
    
    // 🔍 Log database queries for debugging
    public function logQuery($sql, $params = [], $executionTime = null) {
        $context = ['sql' => $sql, 'params' => $params];
        if ($executionTime !== null) {
            $context['execution_time'] = $executionTime . 'ms';
        }
        $this->debug("Database query executed", $context);
    }
    
    // 👤 Log user actions for audit trail
    public function logUserAction($userId, $action, $details = []) {
        $this->info("User action: $action", array_merge(['user_id' => $userId], $details));
    }
    
    // 🔐 Log security events
    public function logSecurityEvent($event, $details = []) {
        $this->warning("Security event: $event", $details);
    }
}

// 3. 🛡️ Global Error Handler
class ErrorHandler {
    private $logger;
    private $isProduction;
    
    public function __construct($logger, $isProduction = false) {
        $this->logger = $logger;
        $this->isProduction = $isProduction;
        
        // 🎯 Register error handlers
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
        
        $this->logger->info("Error handler initialized", ['production' => $isProduction]);
    }
    
    // ⚠️ Handle PHP errors (warnings, notices, etc.)
    public function handleError($severity, $message, $file, $line) {
        // 🚫 Don't handle suppressed errors (@)
        if (!(error_reporting() & $severity)) {
            return;
        }
        
        $context = [
            'file' => $file,
            'line' => $line,
            'severity' => $severity,
            'severity_name' => $this->getSeverityName($severity)
        ];
        
        // 📝 Log the error
        $this->logger->error("PHP Error: $message", $context);
        
        // 🎯 Convert to exception for consistent handling
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
    
    // 💥 Handle uncaught exceptions
    public function handleException($exception) {
        $context = [
            'type' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ];
        
        // 📝 Add extra context for custom exceptions
        if ($exception instanceof DatabaseException) {
            $context = array_merge($context, $exception->getDetailedInfo());
        } elseif ($exception instanceof ValidationException) {
            $context['field'] = $exception->getField();
            $context['value'] = $exception->getValue();
        }
        
        // 🚨 Log as critical error
        $this->logger->critical("Uncaught Exception: " . $exception->getMessage(), $context);
        
        // 👤 Show appropriate error message to user
        if ($this->isProduction) {
            // 🔒 Generic message in production
            $this->showErrorPage("An unexpected error occurred. Please try again later.", 500);
        } else {
            // 🐛 Detailed message in development
            $this->showErrorPage("Error: " . $exception->getMessage() . "\nFile: " . $exception->getFile() . "\nLine: " . $exception->getLine(), 500);
        }
    }
    
    // 💀 Handle fatal errors
    public function handleShutdown() {
        $error = error_get_last();
        
        // 🔍 Check if it was a fatal error
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $context = [
                'file' => $error['file'],
                'line' => $error['line'],
                'type' => $error['type']
            ];
            
            $this->logger->critical("Fatal Error: " . $error['message'], $context);
            
            // 💀 Show fatal error page
            if (!$this->isProduction) {
                $this->showErrorPage("Fatal Error: " . $error['message'], 500);
            }
        }
    }
    
    // 🏷️ Get human-readable severity name
    private function getSeverityName($severity) {
        $severityNames = [
            E_ERROR => 'E_ERROR',
            E_WARNING => 'E_WARNING',
            E_PARSE => 'E_PARSE',
            E_NOTICE => 'E_NOTICE',
            E_STRICT => 'E_STRICT',
            E_DEPRECATED => 'E_DEPRECATED'
        ];
        
        return $severityNames[$severity] ?? 'UNKNOWN';
    }
    
    // 📄 Show error page to user
    private function showErrorPage($message, $statusCode = 500) {
        if (!headers_sent()) {
            http_response_code($statusCode);
            header('Content-Type: text/html; charset=UTF-8');
        }
        
        echo "<!DOCTYPE html>";
        echo "<html><head><title>Error $statusCode</title></head>";
        echo "<body style='font-family: Arial, sans-serif; padding: 20px;'>";
        echo "<h1>🚨 Error $statusCode</h1>";
        echo "<p>" . htmlspecialchars($message) . "</p>";
        echo "<p><small>Error ID: " . uniqid() . "</small></p>";
        echo "</body></html>";
    }
}

// 4. 📊 Enhanced Database Class with Logging
class LoggedDatabase extends MySQLDatabase {
    private $logger;
    
    public function __construct($logger) {
        parent::__construct();
        $this->logger = $logger;
        $this->logger->info("Database connection established");
    }
    
    // 🔍 Override query method to add logging
    public function query($sql, $params = []) {
        $startTime = microtime(true);
        
        try {
            $stmt = parent::query($sql, $params);
            
            // ✅ Log successful query
            $executionTime = round((microtime(true) - $startTime) * 1000, 2);
            $this->logger->logQuery($sql, $params, $executionTime);
            
            return $stmt;
        } catch (PDOException $e) {
            // ❌ Log failed query
            $executionTime = round((microtime(true) - $startTime) * 1000, 2);
            $this->logger->error("Database query failed", [
                'sql' => $sql,
                'params' => $params,
                'execution_time' => $executionTime,
                'error' => $e->getMessage()
            ]);
            
            // 🎯 Throw custom database exception
            throw new DatabaseException("Database query failed: " . $e->getMessage(), $sql, $params, $e->getCode(), $e);
        }
    }
}

// 📖 Usage Examples
try {
    // 🚀 Initialize logging and error handling
    $logger = new Logger('logs/app.log', Logger::DEBUG);
    $errorHandler = new ErrorHandler($logger, false); // Development mode
    
    // 🔗 Create database with logging
    $database = new LoggedDatabase($logger);
    
    // 📝 Log application start
    $logger->info("Application started", ['version' => '1.0.0', 'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI']);
    
    // 🔍 Example of logging user actions
    $logger->logUserAction(123, 'login', ['ip' => '192.168.1.1', 'success' => true]);
    
    // 🛡️ Example of logging security events
    $logger->logSecurityEvent('failed_login_attempt', ['ip' => '192.168.1.100', 'username' => 'admin', 'attempts' => 3]);
    
    // 🎯 Example of custom exception handling
    try {
        $result = $database->query("SELECT * FROM non_existent_table");
    } catch (DatabaseException $e) {
        $logger->error("Database operation failed", $e->getDetailedInfo());
        echo "❌ Database error occurred. Check logs for details.\n";
    }
    
} catch (Exception $e) {
    // 🚨 Fallback error handling
    error_log("Critical error in error handler: " . $e->getMessage());
    echo "🚨 A critical error occurred. Please contact support.\n";
}
?>
```

> 📝 **Logging Best Practices**:
> - **Log levels**: Use appropriate levels (DEBUG for development, INFO for production)
> - **Context**: Include relevant information (user ID, IP address, etc.)
> - **Rotation**: Prevent log files from growing too large
> - **Security**: Don't log sensitive information like passwords
> - **Performance**: Logging should be fast and not slow down your application

## 🔍 Troubleshooting

Professional developers need good troubleshooting tools! Here's your debugging toolkit:

```php
<?php
// 🔧 Professional troubleshooting utilities

class DatabaseTroubleshooter {
    private $logger;
    
    public function __construct($logger = null) {
        $this->logger = $logger ?: new Logger('logs/troubleshoot.log');
    }
    
    // 🔍 Test all database connections
    public static function testConnections() {
        $results = [];
        
        echo "🔍 Testing database connections...\n";
        
        // 🐬 Test MySQL
        try {
            $mysql = new MySQLDatabase();
            $stmt = $mysql->query("SELECT 1 as test");
            $result = $stmt->fetch();
            $results['mysql'] = $result ? '✅ Connected successfully' : '⚠️ Connected but query failed';
        } catch (Exception $e) {
            $results['mysql'] = '❌ Error: ' . $e->getMessage();
        }
        
        // 🐘 Test PostgreSQL
        try {
            $postgres = new PostgreSQLDatabase();
            $stmt = $postgres->query("SELECT 1 as test");
            $result = $stmt->fetch();
            $results['postgresql'] = $result ? '✅ Connected successfully' : '⚠️ Connected but query failed';
        } catch (Exception $e) {
            $results['postgresql'] = '❌ Error: ' . $e->getMessage();
        }
        
        // 🪶 Test SQLite
        try {
            $sqlite = new SQLiteDatabase();
            $stmt = $sqlite->query("SELECT 1 as test");
            $result = $stmt->fetch();
            $results['sqlite'] = $result ? '✅ Connected successfully' : '⚠️ Connected but query failed';
        } catch (Exception $e) {
            $results['sqlite'] = '❌ Error: ' . $e->getMessage();
        }
        
        // 🍃 Test MongoDB
        try {
            $mongo = new MongoDatabase();
            $collection = $mongo->getCollection('test');
            $results['mongodb'] = '✅ Connected successfully';
        } catch (Exception $e) {
            $results['mongodb'] = '❌ Error: ' . $e->getMessage();
        }
        
        return $results;
    }
    
    // 🔌 Check required PHP extensions
    public static function checkPHPExtensions() {
        $extensions = [
            'PDO' => extension_loaded('pdo'),
            'PDO MySQL' => extension_loaded('pdo_mysql'),
            'PDO PostgreSQL' => extension_loaded('pdo_pgsql'),
            'PDO SQLite' => extension_loaded('pdo_sqlite'),
            'MySQLi' => extension_loaded('mysqli'),
            'PostgreSQL' => extension_loaded('pgsql'),
            'MongoDB' => extension_loaded('mongodb'),
            'SQLite3' => extension_loaded('sqlite3'),
            'OpenSSL' => extension_loaded('openssl'),
            'cURL' => extension_loaded('curl'),
            'JSON' => extension_loaded('json')
        ];
        
        echo "🔌 Checking PHP extensions...\n";
        foreach ($extensions as $name => $loaded) {
            echo ($loaded ? "✅" : "❌") . " $name: " . ($loaded ? "Loaded" : "Not loaded") . "\n";
        }
        
        return $extensions;
    }
    
    // 📊 Generate comprehensive diagnostic report
    public static function generateDiagnosticReport() {
        $report = [];
        
        echo "🔍 Generating diagnostic report...\n";
        
        // 🐘 PHP Information
        $report['php_info'] = [
            'version' => PHP_VERSION,
            'sapi' => php_sapi_name(),
            'os' => PHP_OS,
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'date_timezone' => date_default_timezone_get()
        ];
        
        // 🔌 Extensions
        $report['extensions'] = self::checkPHPExtensions();
        
        // 🔗 Database connections
        $report['database_connections'] = self::testConnections();
        
        // 💾 System information
        $report['system_info'] = [
            'current_time' => date('Y-m-d H:i:s'),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'CLI',
            'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? getcwd(),
            'disk_free_space' => self::formatBytes(disk_free_space('.')),
            'memory_usage' => self::formatBytes(memory_get_usage()),
            'memory_peak_usage' => self::formatBytes(memory_get_peak_usage())
        ];
        
        // 📁 File permissions
        $report['file_permissions'] = self::checkFilePermissions();
        
        return $report;
    }
    
    // 📁 Check important file/directory permissions
    private static function checkFilePermissions() {
        $paths = [
            'logs' => 'logs/',
            'cache' => 'cache/',
            'uploads' => 'uploads/',
            'config' => 'config/',
            'current_dir' => '.'
        ];
        
        $permissions = [];
        
        foreach ($paths as $name => $path) {
            if (file_exists($path)) {
                $perms = fileperms($path);
                $permissions[$name] = [
                    'path' => $path,
                    'readable' => is_readable($path),
                    'writable' => is_writable($path),
                    'permissions' => substr(sprintf('%o', $perms), -4)
                ];
            } else {
                $permissions[$name] = [
                    'path' => $path,
                    'exists' => false
                ];
            }
        }
        
        return $permissions;
    }
    
    // 📏 Format bytes in human readable format
    private static function formatBytes($size, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
    
    // 🔍 Test specific database functionality
    public function testDatabaseFunctionality($database, $testTableName = 'test_table') {
        echo "🧪 Testing database functionality...\n";
        
        $results = [];
        
        try {
            // 1. 📝 Test table creation
            echo "📝 Testing table creation...\n";
            $createSql = "CREATE TABLE IF NOT EXISTS $testTableName (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $database->query($createSql);
            $results['table_creation'] = '✅ Success';
            
            // 2. ➕ Test INSERT
            echo "➕ Testing INSERT operation...\n";
            $insertSql = "INSERT INTO $testTableName (name) VALUES (?)";
            $database->query($insertSql, ['Test Record']);
            $results['insert'] = '✅ Success';
            
            // 3. 🔍 Test SELECT
            echo "🔍 Testing SELECT operation...\n";
            $selectSql = "SELECT * FROM $testTableName LIMIT 1";
            $stmt = $database->query($selectSql);
            $record = $stmt->fetch();
            $results['select'] = $record ? '✅ Success' : '⚠️ No data returned';
            
            // 4. ✏️ Test UPDATE
            echo "✏️ Testing UPDATE operation...\n";
            $updateSql = "UPDATE $testTableName SET name = ? WHERE id = ?";
            $database->query($updateSql, ['Updated Test Record', $record['id']]);
            $results['update'] = '✅ Success';
            
            // 5. 🗑️ Test DELETE
            echo "🗑️ Testing DELETE operation...\n";
            $deleteSql = "DELETE FROM $testTableName WHERE id = ?";
            $database->query($deleteSql, [$record['id']]);
            $results['delete'] = '✅ Success';
            
            // 6. 🧹 Clean up - drop test table
            echo "🧹 Cleaning up test table...\n";
            $dropSql = "DROP TABLE IF EXISTS $testTableName";
            $database->query($dropSql);
            $results['cleanup'] = '✅ Success';
            
        } catch (Exception $e) {
            $results['error'] = '❌ ' . $e->getMessage();
            $this->logger->error("Database functionality test failed", [
                'error' => $e->getMessage(),
                'test_table' => $testTableName
            ]);
        }
        
        return $results;
    }
    
    // 🔧 Common database issues and solutions
    public static function diagnoseCommonIssues() {
        echo "🔧 Diagnosing common database issues...\n";
        
        $issues = [];
        
        // 🔌 Check if PDO is available
        if (!extension_loaded('pdo')) {
            $issues[] = [
                'issue' => '❌ PDO extension not loaded',
                'solution' => '💡 Install PHP PDO extension: sudo apt-get install php-pdo (Ubuntu/Debian)'
            ];
        }
        
        // 📁 Check if log directory is writable
        if (!is_writable('logs') && !mkdir('logs', 0755, true)) {
            $issues[] = [
                'issue' => '❌ Cannot write to logs directory',
                'solution' => '💡 Create logs directory and set permissions: mkdir logs && chmod 755 logs'
            ];
        }
        
        // 💾 Check memory limit
        $memoryLimit = ini_get('memory_limit');
        $memoryLimitBytes = self::parseBytes($memoryLimit);
        if ($memoryLimitBytes < 128 * 1024 * 1024) { // Less than 128MB
            $issues[] = [
                'issue' => "⚠️ Low memory limit: $memoryLimit",
                'solution' => '💡 Increase memory_limit in php.ini or use ini_set("memory_limit", "256M")'
            ];
        }
        
        // ⏰ Check execution time limit
        $executionTime = ini_get('max_execution_time');
        if ($executionTime > 0 && $executionTime < 30) {
            $issues[] = [
                'issue' => "⚠️ Low execution time limit: {$executionTime}s",
                'solution' => '💡 Increase max_execution_time in php.ini or use set_time_limit(60)'
            ];
        }
        
        // 🔐 Check if openssl is available for secure connections
        if (!extension_loaded('openssl')) {
            $issues[] = [
                'issue' => '⚠️ OpenSSL extension not loaded',
                'solution' => '💡 Install OpenSSL extension for secure database connections'
            ];
        }
        
        return $issues;
    }
    
    // 📏 Parse memory size strings (like "128M") to bytes
    private static function parseBytes($size) {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $size = (int)$size;
        
        switch ($last) {
            case 'g': $size *= 1024;
            case 'm': $size *= 1024;
            case 'k': $size *= 1024;
        }
        
        return $size;
    }
    
    // 🩺 Health check for database connections
    public function healthCheck($databases = []) {
        echo "🩺 Running database health check...\n";
        
        $health = [
            'overall_status' => 'healthy',
            'timestamp' => date('Y-m-d H:i:s'),
            'checks' => []
        ];
        
        foreach ($databases as $name => $database) {
            echo "🔍 Checking $name database...\n";
            
            try {
                $startTime = microtime(true);
                
                // 🏓 Simple ping test
                $stmt = $database->query("SELECT 1 as ping");
                $result = $stmt->fetch();
                
                $responseTime = round((microtime(true) - $startTime) * 1000, 2);
                
                if ($result && $result['ping'] == 1) {
                    $health['checks'][$name] = [
                        'status' => '✅ healthy',
                        'response_time' => $responseTime . 'ms'
                    ];
                } else {
                    $health['checks'][$name] = [
                        'status' => '⚠️ unhealthy',
                        'issue' => 'Query returned unexpected result'
                    ];
                    $health['overall_status'] = 'degraded';
                }
                
            } catch (Exception $e) {
                $health['checks'][$name] = [
                    'status' => '❌ failed',
                    'error' => $e->getMessage()
                ];
                $health['overall_status'] = 'unhealthy';
                
                $this->logger->error("Health check failed for $name", [
                    'database' => $name,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return $health;
    }
}

// 🛠️ Environment Setup and Validation
class EnvironmentSetup {
    private $config;
    private $logger;
    
    public function __construct($config, $logger = null) {
        $this->config = $config;
        $this->logger = $logger ?: new Logger('logs/setup.log');
    }
    
    // 🚀 Complete environment setup
    public function setupEnvironment() {
        echo "🚀 Setting up development environment...\n";
        
        try {
            // 1. 📁 Create necessary directories
            $this->createDirectories();
            
            // 2. 🗄️ Setup database tables
            $this->createDatabaseTables();
            
            // 3. 🌱 Seed initial data
            $this->seedInitialData();
            
            // 4. ⚙️ Configure application settings
            $this->configureSettings();
            
            // 5. ✅ Validate setup
            $this->validateSetup();
            
            echo "🎉 Environment setup completed successfully!\n";
            
        } catch (Exception $e) {
            echo "❌ Environment setup failed: " . $e->getMessage() . "\n";
            $this->logger->error("Environment setup failed", ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    
    // 📁 Create necessary directories
    private function createDirectories() {
        $directories = ['logs', 'cache', 'uploads', 'backups', 'database'];
        
        foreach ($directories as $dir) {
            if (!file_exists($dir)) {
                if (mkdir($dir, 0755, true)) {
                    echo "📁 Created directory: $dir\n";
                    $this->logger->info("Created directory", ['directory' => $dir]);
                } else {
                    throw new Exception("Failed to create directory: $dir");
                }
            } else {
                echo "📁 Directory already exists: $dir\n";
            }
        }
    }
    
    // 🗄️ Create database tables
    public function createDatabaseTables() {
        echo "🗄️ Creating database tables...\n";
        
        $database = DatabaseFactory::create($this->config['database_type'], $this->config);
        
        $tables = [
            'users' => "
                CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) UNIQUE NOT NULL,
                    email VARCHAR(100) UNIQUE NOT NULL,
                    password_hash VARCHAR(255) NOT NULL,
                    first_name VARCHAR(50),
                    last_name VARCHAR(50),
                    is_active BOOLEAN DEFAULT TRUE,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    last_login TIMESTAMP NULL,
                    INDEX idx_username (username),
                    INDEX idx_email (email),
                    INDEX idx_active (is_active)
                )",
            
            'categories' => "
                CREATE TABLE IF NOT EXISTS categories (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL UNIQUE,
                    description TEXT,
                    parent_id INT DEFAULT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
                    INDEX idx_parent (parent_id),
                    INDEX idx_name (name)
                )",
            
            'products' => "
                CREATE TABLE IF NOT EXISTS products (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    description TEXT,
                    price DECIMAL(10, 2) NOT NULL,
                    stock_quantity INT DEFAULT 0,
                    category_id INT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
                    INDEX idx_category (category_id),
                    INDEX idx_price (price),
                    INDEX idx_name (name),
                    INDEX idx_stock (stock_quantity)
                )",
            
            'orders' => "
                CREATE TABLE IF NOT EXISTS orders (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    customer_id INT NOT NULL,
                    total_amount DECIMAL(10, 2) NOT NULL,
                    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
                    INDEX idx_customer (customer_id),
                    INDEX idx_status (status),
                    INDEX idx_created (created_at)
                )",
            
            'rate_limits' => "
                CREATE TABLE IF NOT EXISTS rate_limits (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    identifier VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    INDEX idx_identifier_time (identifier, created_at)
                )",
            
            'blog_posts' => "
                CREATE TABLE IF NOT EXISTS blog_posts (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    slug VARCHAR(255) UNIQUE NOT NULL,
                    content TEXT NOT NULL,
                    excerpt TEXT,
                    author_id INT NOT NULL,
                    category_id INT,
                    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
                    published_at TIMESTAMP NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
                    INDEX idx_slug (slug),
                    INDEX idx_author (author_id),
                    INDEX idx_category (category_id),
                    INDEX idx_status (status),
                    INDEX idx_published (published_at)
                )"
        ];
        
        foreach ($tables as $tableName => $sql) {
            try {
                $database->query($sql);
                echo "✅ Table '$tableName' created successfully\n";
                $this->logger->info("Table created", ['table' => $tableName]);
            } catch (Exception $e) {
                echo "❌ Error creating table '$tableName': " . $e->getMessage() . "\n";
                $this->logger->error("Failed to create table", ['table' => $tableName, 'error' => $e->getMessage()]);
                throw $e;
            }
        }
    }
    
    // 🌱 Seed initial data
    public function seedInitialData() {
        echo "🌱 Seeding initial data...\n";
        
        $database = DatabaseFactory::create($this->config['database_type'], $this->config);
        
        try {
            // 🗂️ Create sample categories
            $categories = [
                ['name' => 'Electronics', 'description' => 'Electronic devices and gadgets'],
                ['name' => 'Books', 'description' => 'Books and literature'],
                ['name' => 'Clothing', 'description' => 'Apparel and accessories'],
                ['name' => 'Home & Garden', 'description' => 'Home improvement and garden supplies'],
                ['name' => 'Sports', 'description' => 'Sports equipment and accessories']
            ];
            
            foreach ($categories as $category) {
                try {
                    $database->query(
                        "INSERT IGNORE INTO categories (name, description) VALUES (?, ?)",
                        [$category['name'], $category['description']]
                    );
                    echo "✅ Seeded category: {$category['name']}\n";
                } catch (Exception $e) {
                    // Skip if already exists
                    if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                        throw $e;
                    }
                }
            }
            
            // 👤 Create admin user
            $adminPassword = password_hash('admin123!', PASSWORD_DEFAULT);
            try {
                $database->query(
                    "INSERT IGNORE INTO users (username, email, password_hash, first_name, last_name, is_active) 
                     VALUES (?, ?, ?, ?, ?, ?)",
                    ['admin', 'admin@example.com', $adminPassword, 'Admin', 'User', 1]
                );
                echo "✅ Created admin user (username: admin, password: admin123!)\n";
                $this->logger->info("Admin user created", ['username' => 'admin']);
            } catch (Exception $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                    throw $e;
                }
                echo "ℹ️ Admin user already exists\n";
            }
            
            // 📦 Create sample products
            $this->seedSampleProducts($database);
            
        } catch (Exception $e) {
            echo "❌ Error seeding data: " . $e->getMessage() . "\n";
            $this->logger->error("Failed to seed data", ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    
    // 📦 Seed sample products
    private function seedSampleProducts($database) {
        $products = [
            ['name' => 'Laptop Computer', 'description' => 'High-performance laptop', 'price' => 999.99, 'stock' => 10, 'category' => 'Electronics'],
            ['name' => 'Programming Book', 'description' => 'Learn PHP and databases', 'price' => 49.99, 'stock' => 25, 'category' => 'Books'],
            ['name' => 'T-Shirt', 'description' => 'Comfortable cotton t-shirt', 'price' => 19.99, 'stock' => 50, 'category' => 'Clothing'],
            ['name' => 'Garden Tools Set', 'description' => 'Complete gardening toolkit', 'price' => 79.99, 'stock' => 15, 'category' => 'Home & Garden'],
            ['name' => 'Basketball', 'description' => 'Professional basketball', 'price' => 29.99, 'stock' => 20, 'category' => 'Sports']
        ];
        
        foreach ($products as $product) {
            // Get category ID
            $categoryStmt = $database->query("SELECT id FROM categories WHERE name = ?", [$product['category']]);
            $category = $categoryStmt->fetch();
            
            if ($category) {
                try {
                    $database->query(
                        "INSERT IGNORE INTO products (name, description, price, stock_quantity, category_id) 
                         VALUES (?, ?, ?, ?, ?)",
                        [$product['name'], $product['description'], $product['price'], $product['stock'], $category['id']]
                    );
                    echo "✅ Seeded product: {$product['name']}\n";
                } catch (Exception $e) {
                    if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                        throw $e;
                    }
                }
            }
        }
    }
    
    // ⚙️ Configure application settings
    private function configureSettings() {
        echo "⚙️ Configuring application settings...\n";
        
        // Create configuration file if it doesn't exist
        $configFile = 'config/app_config.php';
        if (!file_exists($configFile)) {
            $configContent = "<?php\n";
            $configContent .= "// 🔧 Application Configuration\n";
            $configContent .= "define('APP_NAME', 'PHP Database Learning App');\n";
            $configContent .= "define('APP_VERSION', '1.0.0');\n";
            $configContent .= "define('DEBUG_MODE', true);\n";
            $configContent .= "define('LOG_LEVEL', 'DEBUG');\n";
            $configContent .= "define('TIMEZONE', 'UTC');\n";
            $configContent .= "?>\n";
            
            if (file_put_contents($configFile, $configContent)) {
                echo "✅ Created application configuration file\n";
            } else {
                throw new Exception("Failed to create configuration file");
            }
        }
        
        // Set timezone
        date_default_timezone_set('UTC');
        echo "✅ Timezone configured\n";
    }
    
    // ✅ Validate complete setup
    private function validateSetup() {
        echo "✅ Validating setup...\n";
        
        $troubleshooter = new DatabaseTroubleshooter($this->logger);
        
        // Test database connections
        $connections = $troubleshooter::testConnections();
        foreach ($connections as $db => $status) {
            echo "  $db: $status\n";
        }
        
        // Check required extensions
        $extensions = $troubleshooter::checkPHPExtensions();
        $missingExtensions = array_filter($extensions, function($loaded) { return !$loaded; });
        
        if (!empty($missingExtensions)) {
            echo "⚠️ Missing extensions: " . implode(', ', array_keys($missingExtensions)) . "\n";
        } else {
            echo "✅ All required extensions are loaded\n";
        }
        
        // Diagnose common issues
        $issues = $troubleshooter::diagnoseCommonIssues();
        if (!empty($issues)) {
            echo "⚠️ Found potential issues:\n";
            foreach ($issues as $issue) {
                echo "  {$issue['issue']}\n";
                echo "  {$issue['solution']}\n\n";
            }
        } else {
            echo "✅ No common issues detected\n";
        }
    }
}

// 📖 Usage Examples and Diagnostic Commands
if (basename(__FILE__) == basename($_SERVER['SCRIPT_NAME'])) {
    echo "🔧 PHP Database Troubleshooting Toolkit\n";
    echo "=====================================\n\n";
    
    try {
        // 🔍 Generate diagnostic report
        echo "📊 DIAGNOSTIC REPORT\n";
        echo "===================\n";
        $report = DatabaseTroubleshooter::generateDiagnosticReport();
        
        // Display key information
        echo "🐘 PHP Version: " . $report['php_info']['version'] . "\n";
        echo "💾 Memory Limit: " . $report['php_info']['memory_limit'] . "\n";
        echo "⏰ Max Execution Time: " . $report['php_info']['max_execution_time'] . "s\n";
        echo "🌍 Timezone: " . $report['php_info']['date_timezone'] . "\n\n";
        
        // Show database connection status
        echo "🔗 DATABASE CONNECTIONS\n";
        echo "======================\n";
        foreach ($report['database_connections'] as $db => $status) {
            echo "  $db: $status\n";
        }
        echo "\n";
        
        // Show critical extensions
        echo "🔌 CRITICAL EXTENSIONS\n";
        echo "=====================\n";
        $criticalExtensions = ['PDO', 'PDO MySQL', 'JSON', 'OpenSSL'];
        foreach ($criticalExtensions as $ext) {
            $status = $report['extensions'][$ext] ? '✅' : '❌';
            echo "  $status $ext\n";
        }
        echo "\n";
        
        // Diagnose issues
        echo "🔧 ISSUE DIAGNOSIS\n";
        echo "=================\n";
        $issues = DatabaseTroubleshooter::diagnoseCommonIssues();
        if (empty($issues)) {
            echo "✅ No issues detected!\n";
        } else {
            foreach ($issues as $issue) {
                echo "{$issue['issue']}\n";
                echo "{$issue['solution']}\n\n";
            }
        }
        
        // Save full report to file
        $reportJson = json_encode($report, JSON_PRETTY_PRINT);
        file_put_contents('logs/diagnostic_report_' . date('Y-m-d_H-i-s') . '.json', $reportJson);
        echo "📁 Full diagnostic report saved to logs/\n";
        
    } catch (Exception $e) {
        echo "❌ Diagnostic failed: " . $e->getMessage() . "\n";
    }
}
?>
```

## 📋 Project Structure

Here's how to organize your PHP database project professionally:

```
🏗️ php-database-project/
├── 📁 config/                    # Configuration files
│   ├── 🔧 database.php          # Database configurations
│   ├── ⚙️ app.php               # Application settings
│   └── 🔐 security.php          # Security configurations
├── 📁 classes/                   # Core database classes
│   ├── 🐬 MySQLDatabase.php     # MySQL connection class
│   ├── 🐘 PostgreSQLDatabase.php # PostgreSQL connection class
│   ├── 🪶 SQLiteDatabase.php    # SQLite connection class
│   ├── 🍃 Mon📄 Text data
$integer = 42;                     // 🔢 Whole numbers
$float = 3.14;                     // 🔢 Decimal numbers
$boolean = true;                   // ✅ True/False values
$array = array("apple", "banana", "cherry");  // 📦 List of items
$associative_array = array("name" => "John", "age" => 30);  // 🏷️ Key-value pairs

// 🔧 Functions - Reusable code blocks
function calculateAge($birthYear) {
    return date("Y") - $birthYear;  // 📅 Current year minus birth year
}

// 🏗️ Classes and Objects - Object-oriented programming basics
class User {
    private $name;    // 🔒 Private property (only accessible within class)
    private $email;   // 🔒 Private property
    
    // 🏁 Constructor - runs when object is created
    public function __construct($name, $email) {
        $this->name = $name;      // 👤 Set user's name
        $this->email = $email;    // 📧 Set user's email
    }
    
    // 🔓 Public method - accessible from outside the class
    public function getName() {
        return $this->name;
    }
}

// ⚠️ Error Handling - Deal with problems gracefully
try {
    // 🎯 Risky operation that might fail
    $result = 10 / 0;  // This will cause an error!
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();  // 📢 Display error message
}
?>
```

> 🎓 **Learning Note**: Don't worry if this seems complex! We'll use these concepts step by step throughout the guide.

## 🗄️ Database Platforms

### 1. 🐬 MySQL/MariaDB Configuration

MySQL is like the "most popular kid in school" of databases - widely used and well-supported! 

#### 📦 Installation and Basic Setup

```bash
# 🐧 Ubuntu/Debian installation
sudo apt-get install mysql-server php-mysql

# 🚀 Start MySQL service
sudo systemctl start mysql
sudo systemctl enable mysql

# 🔐 Secure installation (highly recommended!)
sudo mysql_secure_installation
```

> 💡 **Beginner Explanation**: MySQL is a database management system that stores your data in organized tables, like a super-powered Excel spreadsheet!

#### 🔗 Basic MySQL Connection

```php
<?php
// 📁 config/mysql_config.php
// 🏠 Database connection settings - like your database's address book
define('DB_HOST', 'localhost');      // 🏠 Where is your database? (usually localhost for development)
define('DB_USER', 'your_username');  // 👤 Your database username
define('DB_PASS', 'your_password');  // 🔑 Your database password
define('DB_NAME', 'your_database');  // 🗄️ Name of your database

// 🔌 Using MySQLi (Procedural) - The old-school way
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// ✅ Check if connection was successful
if (!$connection) {
    die("❌ Connection failed: " . mysqli_connect_error());
}

echo "✅ Connected successfully to MySQL";
mysqli_close($connection);  // 🚪 Always close the connection when done!
?>
```

> 🎯 **Key Point**: Always check if your connection succeeded before trying to use it!

#### 🚀 MySQL with PDO (Professional Way)

```php
<?php
// 📁 classes/MySQLDatabase.php
// 🏗️ A professional database class - like building a house with proper blueprints!
class MySQLDatabase {
    private $pdo;                    // 🔗 Our database connection
    private $host = 'localhost';     // 🏠 Database server location
    private $dbname = 'your_database';   // 🗄️ Database name
    private $username = 'your_username'; // 👤 Login username
    private $password = 'your_password'; // 🔑 Login password
    
    // 🏁 Constructor - automatically runs when class is created
    public function __construct() {
        try {
            // 🛣️ DSN = Data Source Name (like a GPS coordinate for your database)
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            
            // 🔌 Create the connection with security settings
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // 🚨 Throw errors instead of hiding them
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // 📊 Return data as associative arrays
                PDO::ATTR_EMULATE_PREPARES => false  // 🛡️ Use real prepared statements for security
            ]);
        } catch (PDOException $e) {
            // 🚨 If connection fails, throw a helpful error
            throw new Exception("❌ Database connection failed: " . $e->getMessage());
        }
    }
    
    // 🎯 Execute database queries safely
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);  // 🛡️ Prepare statement for security
            $stmt->execute($params);            // ⚡ Execute with parameters
            return $stmt;                       // 📤 Return the result
        } catch (PDOException $e) {
            throw new Exception("❌ Query failed: " . $e->getMessage());
        }
    }
    
    // 🔗 Get the raw PDO connection if needed
    public function getConnection() {
        return $this->pdo;
    }
}
?>
```

> 🛡️ **Security Note**: PDO with prepared statements protects you from SQL injection attacks - like having a bouncer at your database's door!

### 2. 🐘 PostgreSQL Configuration

PostgreSQL is like the "scholarly professor" of databases - very powerful and feature-rich!

#### 📦 Installation and Setup

```bash
# 🐧 Ubuntu/Debian installation
sudo apt-get install postgresql postgresql-contrib php-pgsql

# 👤 Switch to postgres user (like becoming a database admin)
sudo -u postgres psql

# 🏗️ Create database and user (run these in PostgreSQL prompt)
CREATE DATABASE your_database;
CREATE USER your_username WITH PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE your_database TO your_username;
```

> 💡 **Beginner Tip**: PostgreSQL uses different commands than MySQL, but the concepts are the same - just like different languages saying the same thing!

#### 🔗 PostgreSQL Connection

```php
<?php
// 📁 classes/PostgreSQLDatabase.php
class PostgreSQLDatabase {
    private $pdo;                    // 🔗 Database connection
    private $host = 'localhost';     // 🏠 Server location
    private $port = '5432';          // 🚪 Port number (PostgreSQL's default door)
    private $dbname = 'your_database';   // 🗄️ Database name
    private $username = 'your_username'; // 👤 Username
    private $password = 'your_password'; // 🔑 Password
    
    public function __construct() {
        try {
            // 🛣️ PostgreSQL DSN format (slightly different from MySQL)
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            
            // 🔌 Create connection
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 🚨 Show errors
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC    // 📊 Return associative arrays
            ]);
        } catch (PDOException $e) {
            throw new Exception("❌ PostgreSQL connection failed: " . $e->getMessage());
        }
    }
    
    // 🎯 Execute queries (same method as MySQL - consistency is key!)
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("❌ Query failed: " . $e->getMessage());
        }
    }
}
?>
```

### 3. 🪶 SQLite Configuration

SQLite is like a "portable database in a file" - perfect for development and small applications!

#### 🔗 SQLite Connection

```php
<?php
// 📁 classes/SQLiteDatabase.php
class SQLiteDatabase {
    private $pdo;              // 🔗 Database connection
    private $dbPath;           // 📂 Path to SQLite file
    
    // 🏁 Constructor with default database path
    public function __construct($dbPath = 'database/app.sqlite') {
        $this->dbPath = $dbPath;
        $this->createDatabaseDirectory();  // 📁 Make sure directory exists
        $this->connect();                  // 🔌 Connect to database
    }
    
    // 📁 Create directory if it doesn't exist
    private function createDatabaseDirectory() {
        $directory = dirname($this->dbPath);  // 📂 Get directory path
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);    // 🏗️ Create directory recursively
        }
    }
    
    // 🔌 Connect to SQLite database
    private function connect() {
        try {
            // 🛣️ SQLite DSN is just the file path
            $this->pdo = new PDO("sqlite:" . $this->dbPath, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 🚨 Show errors
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC    // 📊 Return associative arrays
            ]);
        } catch (PDOException $e) {
            throw new Exception("❌ SQLite connection failed: " . $e->getMessage());
        }
    }
    
    // 🎯 Execute queries (same interface as other databases)
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("❌ Query failed: " . $e->getMessage());
        }
    }
}
?>
```

> 🎯 **When to Use SQLite**: Perfect for development, testing, or small applications that don't need multiple users accessing simultaneously.

### 4. 🍃 MongoDB Configuration

MongoDB is like a "flexible filing cabinet" - stores documents instead of rigid table rows!

#### 📦 Installation and Setup

```bash
# 🐧 Ubuntu/Debian installation
sudo apt-get install mongodb php-mongodb

# 🚀 Start MongoDB service
sudo systemctl start mongodb
sudo systemctl enable mongodb
```

> 💡 **NoSQL Explanation**: Unlike traditional databases with tables and rows, MongoDB stores data as "documents" (like JSON objects). Think of it as storing entire forms instead of breaking them into table cells!

#### 🔗 MongoDB Connection

```php
<?php
// 📁 classes/MongoDatabase.php
require_once 'vendor/autoload.php'; // 📦 Install via: composer require mongodb/mongodb

use MongoDB\Client;
use MongoDB\Exception\Exception as MongoException;

class MongoDatabase {
    private $client;                           // 🔗 MongoDB client
    private $database;                         // 🗄️ Database reference
    private $uri = 'mongodb://localhost:27017'; // 🛣️ MongoDB connection string
    private $databaseName = 'your_database';   // 🏷️ Database name
    
    public function __construct() {
        try {
            // 🔌 Connect to MongoDB
            $this->client = new Client($this->uri);
            $this->database = $this->client->selectDatabase($this->databaseName);
        } catch (MongoException $e) {
            throw new Exception("❌ MongoDB connection failed: " . $e->getMessage());
        }
    }
    
    // 📂 Get a collection (like a table in SQL databases)
    public function getCollection($collectionName) {
        return $this->database->selectCollection($collectionName);
    }
    
    // ➕ Insert a document (like adding a row in SQL)
    public function insertDocument($collection, $document) {
        try {
            $result = $this->getCollection($collection)->insertOne($document);
            return $result->getInsertedId();  // 🆔 Return the new document's ID
        } catch (MongoException $e) {
            throw new Exception("❌ Insert failed: " . $e->getMessage());
        }
    }
    
    // 🔍 Find documents (like SELECT in SQL)
    public function findDocuments($collection, $filter = [], $options = []) {
        try {
            return $this->getCollection($collection)->find($filter, $options);
        } catch (MongoException $e) {
            throw new Exception("❌ Find failed: " . $e->getMessage());
        }
    }
}
?>
```

> 🔄 **SQL vs NoSQL**: In SQL you have tables with rows and columns. In MongoDB you have collections with documents (JSON-like objects). Both store data, just organized differently!

## 🔗 Database Connection Methods

### 1. 🏭 Singleton Pattern for Database Connection

The Singleton pattern ensures you only create one database connection that everyone shares - like having one key to the database that everyone uses!

```php
<?php
// 📁 classes/DatabaseManager.php
class DatabaseManager {
    private static $instances = [];    // 📦 Store our single instances
    private $connections = [];         // 🔗 Store database connections
    
    // 🔒 Private constructor prevents direct creation
    private function __construct() {}
    
    // 🎯 Get the single instance of this class
    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();  // 🏗️ Create only if doesn't exist
        }
        return self::$instances[$class];
    }
    
    // 🔗 Get database connection by type
    public function getConnection($type = 'mysql') {
        if (!isset($this->connections[$type])) {
            // 🏗️ Create connection only if it doesn't exist
            switch ($type) {
                case 'mysql':
                    $this->connections[$type] = new MySQLDatabase();
                    break;
                case 'postgresql':
                    $this->connections[$type] = new PostgreSQLDatabase();
                    break;
                case 'sqlite':
                    $this->connections[$type] = new SQLiteDatabase();
                    break;
                case 'mongodb':
                    $this->connections[$type] = new MongoDatabase();
                    break;
                default:
                    throw new Exception("❌ Unsupported database type: $type");
            }
        }
        return $this->connections[$type];  // 📤 Return existing connection
    }
}
?>
```

> 🎯 **Why Singleton?**: Instead of creating multiple database connections (expensive!), we create one and reuse it. Like sharing a car instead of everyone buying their own!

### 2. 🏭 Database Factory Pattern

The Factory pattern is like a "database connection vending machine" - you tell it what you want, and it gives you the right type!

```php
<?php
// 📁 classes/DatabaseFactory.php
class DatabaseFactory {
    // 🏗️ Create database connection based on type
    public static function create($type, $config = []) {
        switch (strtolower($type)) {
            case 'mysql':
                return new MySQLDatabase($config);      // 🐬 MySQL connection
            case 'postgresql':
                return new PostgreSQLDatabase($config); // 🐘 PostgreSQL connection
            case 'sqlite':
                return new SQLiteDatabase($config);     // 🪶 SQLite connection
            case 'mongodb':
                return new MongoDatabase($config);      // 🍃 MongoDB connection
            default:
                throw new Exception("❌ Unsupported database type: $type");
        }
    }
}

// 📖 Usage Examples
$mysql = DatabaseFactory::create('mysql');        // 🐬 Get MySQL connection
$postgres = DatabaseFactory::create('postgresql'); // 🐘 Get PostgreSQL connection
?>
```

> 💡 **Factory vs Singleton**: Factory creates new instances each time, Singleton reuses the same instance. Choose based on your needs!

## 🌍 Real-World Examples

### 1. 🛒 E-commerce Product Management System

Let's build a real e-commerce system! This is what you'd actually use in a professional setting.

#### 🗄️ Database Schema (MySQL)

```sql
-- 📦 Products table - stores all your products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- 🆔 Unique product ID
    name VARCHAR(255) NOT NULL,                  -- 🏷️ Product name
    description TEXT,                            -- 📄 Product description
    price DECIMAL(10, 2) NOT NULL,              -- 💰 Price (10 digits, 2 decimal places)
    stock_quantity INT DEFAULT 0,               -- 📊 How many in stock
    category_id INT,                            -- 🗂️ Link to category
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,        -- 📅 When created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- 📅 When last updated
    INDEX idx_category (category_id),           -- 🚀 Speed up category searches
    INDEX idx_price (price)                     -- 🚀 Speed up price searches
);

-- 🗂️ Categories table - organize products
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- 🆔 Unique category ID
    name VARCHAR(100) NOT NULL UNIQUE,          -- 🏷️ Category name (must be unique)
    description TEXT,                           -- 📄 Category description
    parent_id INT DEFAULT NULL,                 -- 👨‍👩‍👧‍👦 Parent category (for subcategories)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 🛍️ Orders table - customer orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- 🆔 Unique order ID
    customer_id INT NOT NULL,                   -- 👤 Who placed the order
    total_amount DECIMAL(10, 2) NOT NULL,       -- 💰 Total order value
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',  -- 📊 Order status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_customer (customer_id),          -- 🚀 Speed up customer searches
    INDEX idx_status (status)                  -- 🚀 Speed up status searches
);
```

> 📚 **Database Design Tip**: Always add indexes on columns you'll search frequently - they're like bookmarks in a huge book!

#### 🏗️ Product Class with Database Operations

```php
<?php
// 📁 models/Product.php
// 🛒 Complete product management class for e-commerce
class Product {
    private $db;                    // 🔗 Database connection
    private $id;                    // 🆔 Product ID
    private $name;                  // 🏷️ Product name
    private $description;           // 📄 Product description
    private $price;                 // 💰 Product price
    private $stock_quantity;        // 📊 Stock quantity
    private $category_id;           // 🗂️ Category ID
    
    // 🏁 Constructor - initialize with database connection
    public function __construct($database) {
        $this->db = $database;
    }
    
    // ➕ Create a new product
    public function create($data) {
        $sql = "INSERT INTO products (name, description, price, stock_quantity, category_id) 
                VALUES (:name, :description, :price, :stock_quantity, :category_id)";
        
        try {
            $stmt = $this->db->query($sql, [
                ':name' => $data['name'],                    // 🏷️ Product name
                ':description' => $data['description'],      // 📄 Description
                ':price' => $data['price'],                  // 💰 Price
                ':stock_quantity' => $data['stock_quantity'], // 📊 Stock
                ':category_id' => $data['category_id']       // 🗂️ Category
            ]);
            
            return $this->db->getConnection()->lastInsertId();  // 📤 Return new product ID
        } catch (Exception $e) {
            throw new Exception("❌ Failed to create product: " . $e->getMessage());
        }
    }
    
    // 🔍 Read product by ID (with category information)
    public function findById($id) {
        // 🔗 JOIN query to get product with category name
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        
        try {
            $stmt = $this->db->query($sql, [':id' => $id]);
            return $stmt->fetch();  // 📤 Return single product
        } catch (Exception $e) {
            throw new Exception("❌ Failed to find product: " . $e->getMessage());
        }
    }
    
    // ✏️ Update product information
    public function update($id, $data) {
        $sql = "UPDATE products SET name = :name, description = :description, 
                price = :price, stock_quantity = :stock_quantity, category_id = :category_id 
                WHERE id = :id";
        
        try {
            $params = array_merge($data, [':id' => $id]);  // 🔗 Merge data with ID
            $stmt = $this->db->query($sql, $params);
            return $stmt->rowCount() > 0;  // ✅ Return true if updated
        } catch (Exception $e) {
            throw new Exception("❌ Failed to update product: " . $e->getMessage());
        }
    }
    
    // 🗑️ Delete product
    public function delete($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        
        try {
            $stmt = $this->db->query($sql, [':id' => $id]);
            return $stmt->rowCount() > 0;  // ✅ Return true if deleted
        } catch (Exception $e) {
            throw new Exception("❌ Failed to delete product: " . $e->getMessage());
        }
    }
    
    // 📊 Get products with pagination and filtering
    public function getProducts($filters = [], $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;  // 📄 Calculate offset for pagination
        $whereClause = "";               // 🔍 Build WHERE clause dynamically
        $params = [];                    // 📝 Parameters for prepared statement
        
        // 🗂️ Filter by category
        if (!empty($filters['category_id'])) {
            $whereClause .= " WHERE p.category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
        }
        
        // 💰 Filter by minimum price
        if (!empty($filters['min_price'])) {
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " p.price >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }
        
        // 💰 Filter by maximum price
        if (!empty($filters['max_price'])) {
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " p.price <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }
        
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                $whereClause 
                ORDER BY p.created_at DESC 
                LIMIT :limit OFFSET :offset";
        
        $params[':limit'] = $limit;    // 📊 How many results per page
        $params[':offset'] = $offset;  // 📄 How many to skip
        
        try {
            $stmt = $this->db->query($sql, $params);
            return $stmt->fetchAll();  // 📤 Return all matching products
        } catch (Exception $e) {
            throw new Exception("❌ Failed to get products: " . $e->getMessage());
        }
    }
    
    // 🔍 Search products by name or description
    public function search($term, $limit = 10) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE :term OR p.description LIKE :term 
                ORDER BY p.name 
                LIMIT :limit";
        
        try {
            $stmt = $this->db->query($sql, [
                ':term' => "%$term%",      // 🔍 Wildcard search (matches anywhere in text)
                ':limit' => $limit
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("❌ Failed to search products: " . $e->getMessage());
        }
    }
}
?>
```

> 💡 **Professional Tip**: Notice how we use prepared statements everywhere? This prevents SQL injection attacks - one of the most common web security vulnerabilities!

### 2. 🔐 User Authentication System

Let's build a secure user system that you'd use in any professional application!

```php
<?php
// 📁 models/User.php
class User {
    private $db;  // 🔗 Database connection
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // 📝 Register new user
    public function register($userData) {
        // ✅ Validate input data
        if (empty($userData['email']) || empty($userData['password'])) {
            throw new Exception("❌ Email and password are required");
        }
        
        // 🔍 Check if user already exists
        if ($this->emailExists($userData['email'])) {
            throw new Exception("❌ Email already registered");
        }
        
        // 🔐 Hash password securely (NEVER store plain passwords!)
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, email, password_hash, first_name, last_name) 
                VALUES (:username, :email, :password_hash, :first_name, :last_name)";
        
        try {
            $stmt = $this->db->query($sql, [
                ':username' => $userData['username'],
                ':email' => $userData['email'],
                ':password_hash' => $hashedPassword,  // 🔐 Store hashed password
                ':first_name' => $userData['first_name'],
                ':last_name' => $userData['last_name']
            ]);
            
            return $this->db->getConnection()->lastInsertId();  // 📤 Return new user ID
        } catch (Exception $e) {
            throw new Exception("❌ Registration failed: " . $e->getMessage());
        }
    }
    
    // 🚪 User login
    public function login($email, $password) {
        $sql = "SELECT id, email, password_hash, username, first_name, last_name, is_active 
                FROM users WHERE email = :email";
        
        try {
            $stmt = $this->db->query($sql, [':email' => $email]);
            $user = $stmt->fetch();
            
            // 🔍 Check if user exists
            if (!$user) {
                throw new Exception("❌ Invalid email or password");
            }
            
            // ✅ Check if account is active
            if (!$user['is_active']) {
                throw new Exception("❌ Account is deactivated");
            }
            
            // 🔐 Verify password against hash
            if (!password_verify($password, $user['password_hash'])) {
                throw new Exception("❌ Invalid email or password");
            }
            
            // 📅 Update last login timestamp
            $this->updateLastLogin($user['id']);
            
            // 🔒 Remove password hash from returned data (security!)
            unset($user['password_hash']);
            
            return $user;  // 📤 Return user data (without password)
        } catch (Exception $e) {
            throw new Exception("❌ Login failed: " . $e->getMessage());
        }
    }
    
    //
