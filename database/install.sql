-- ============================================
-- Sportly 数据库安装脚本
-- ============================================
-- 请在执行此脚本前创建数据库
-- CREATE DATABASE sportly CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE sportly;

-- ============================================
-- 1. 博客文章表 (google_blogs)
-- ============================================
CREATE TABLE IF NOT EXISTS `google_blogs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `title_uniq` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题唯一标识',
  `h1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'h1',
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '描述',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '内容',
  `content_faq` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'FAQ内容',
  `head_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '头图',
  `keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `language` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '语言',
  `published_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `category_id` int DEFAULT '0' COMMENT '分类id',
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `volume` int NOT NULL DEFAULT '0' COMMENT '阅读量',
  `author` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '作者',
  `state` tinyint DEFAULT '1' COMMENT '状态 1-正常 2-不可用',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `title_uniq` (`title_uniq`) USING BTREE,
  KEY `idx_language` (`language`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_state` (`state`),
  KEY `idx_published_at` (`published_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC COMMENT='博客文章表';

-- ============================================
-- 2. 分类表 (google_categorys)
-- ============================================
CREATE TABLE IF NOT EXISTS `google_categorys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `slug` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分类slug',
  `uri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分类uri',
  `language` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '所属语言',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '分类状态 1-可用 2-不可用',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_language` (`language`),
  KEY `idx_state` (`state`),
  KEY `idx_uri` (`uri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC COMMENT='分类表';

-- ============================================
-- 3. 物料任务表 (materiel_tasks)
-- ============================================
CREATE TABLE IF NOT EXISTS `materiel_tasks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `language_code` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'en' COMMENT '语言code',
  `type` tinyint NOT NULL DEFAULT '0' COMMENT '类型 1=首页 2=about us 3=contact us 4=policy 5=logo 6=icon 7=分类',
  `seo_title` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'meta中的标题',
  `seo_desc` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'meta中的描述',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `category_id` int NOT NULL DEFAULT '0' COMMENT '分类id',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '导航名称',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_language_code` (`language_code`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='物料任务表';

-- ============================================
-- 4. 插入示例数据
-- ============================================

-- 插入分类数据
INSERT INTO `google_categorys` (`name`, `slug`, `uri`, `language`, `state`, `created_at`, `updated_at`) VALUES
('Running', 'running', 'running', 'en', 1, NOW(), NOW()),
('Cycling', 'cycling', 'cycling', 'en', 1, NOW(), NOW()),
('Swimming', 'swimming', 'swimming', 'en', 1, NOW(), NOW());

-- 插入首页SEO信息
INSERT INTO `materiel_tasks` (`language_code`, `type`, `seo_title`, `seo_desc`, `content`, `name`) VALUES
('en', 1, 'SportlyTech - Technology drives the evolution of sports', 'Discover the latest in sports technology, from running and cycling to swimming. Stay updated with expert insights and innovative solutions.', NULL, 'Home');

-- 插入About Us页面
INSERT INTO `materiel_tasks` (`language_code`, `type`, `seo_title`, `seo_desc`, `content`, `name`) VALUES
('en', 2, 'About Us - SportlyTech', 'Learn more about SportlyTech and our mission to bring technology to sports.', 
'<h2>About SportlyTech</h2><p>SportlyTech is a leading platform dedicated to exploring the intersection of technology and sports. We provide in-depth articles, analysis, and insights into how technology is revolutionizing the way we train, compete, and enjoy sports.</p><h3>Our Mission</h3><p>Our mission is to empower athletes, coaches, and sports enthusiasts with the knowledge and tools they need to leverage technology for better performance and enjoyment.</p>', 
'About');

-- 插入Contact Us页面
INSERT INTO `materiel_tasks` (`language_code`, `type`, `seo_title`, `seo_desc`, `content`, `name`) VALUES
('en', 3, 'Contact Us - SportlyTech', 'Get in touch with the SportlyTech team.', 
'<h2>Contact Us</h2><p>We would love to hear from you! Whether you have questions, feedback, or suggestions, please feel free to reach out to us.</p><p><strong>Email:</strong> info@sportlytech.com</p><p><strong>Address:</strong> 123 Tech Street, Sports City, SC 12345</p>', 
'Contact');

-- 插入Privacy Policy页面
INSERT INTO `materiel_tasks` (`language_code`, `type`, `seo_title`, `seo_desc`, `content`, `name`) VALUES
('en', 4, 'Privacy Policy - SportlyTech', 'Read our privacy policy to understand how we protect your data.', 
'<h2>Privacy Policy</h2><p>Your privacy is important to us. This privacy policy explains how we collect, use, and protect your personal information.</p><h3>Information We Collect</h3><p>We collect information that you provide to us directly, such as when you create an account, subscribe to our newsletter, or contact us.</p><h3>How We Use Your Information</h3><p>We use your information to provide and improve our services, communicate with you, and comply with legal obligations.</p>', 
'Privacy');

-- 插入示例博客文章
INSERT INTO `google_blogs` (`title`, `title_uniq`, `h1`, `summary`, `content`, `content_faq`, `head_img`, `keyword`, `language`, `published_at`, `category_id`, `category_name`, `volume`, `author`, `state`) VALUES
('The fascinating story behind the making of Margaret Atwood', 'margaret-atwood-story-001', 'The fascinating story behind the making of Margaret Atwood', 
'While Black Friday is technically weeks away, several retailers have either already launched early Black Friday sales or have announced upcoming dates.', 
'<h2>Behind the making of Margaret Atwood</h2><p>With nearly every step, my microspikes slipped off the soles of my chunky boots. I couldn''t have picked worse footwear for this intense situation, never mind falling, so I pushed light on the brakes.</p><p>With nearly every step, my microspikes slipped off the soles of my chunky boots. I couldn''t have picked worse footwear for this intense situation, never mind falling, so I pushed light on the brakes.</p><h3>Microspikes slipped off the soles</h3><p>With nearly every step, my microspikes slipped off the soles of my chunky boots. I couldn''t have picked worse footwear for this intense situation, never mind falling, so I pushed light on the brakes.</p>', 
'<h3>Microspikes slipped off the soles?</h3><p>With nearly every step, my microspikes slipped off the soles of my chunky boots. I couldn''t have picked worse footwear for this intense situation.</p>', 
'/images/sample-running.jpg', 'running, sports, technology', 'en', NOW(), 1, 'Running', 156, 'Jackson', 1);

-- ============================================
-- 安装完成提示
-- ============================================
-- 数据库安装完成！
-- 接下来请：
-- 1. 配置.env文件中的数据库连接信息
-- 2. 运行: php artisan key:generate
-- 3. 配置Web服务器
-- 4. 访问网站
