-- database/schema.sql
DROP DATABASE IF EXISTS logistics_college;
CREATE DATABASE logistics_college CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE logistics_college;

CREATE TABLE admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE hero_sections (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  background_image VARCHAR(255) DEFAULT NULL,
  main_heading VARCHAR(255) DEFAULT NULL,
  sub_heading TEXT DEFAULT NULL,
  button_text_1 VARCHAR(100) DEFAULT NULL,
  button_link_1 VARCHAR(255) DEFAULT NULL,
  button_text_2 VARCHAR(100) DEFAULT NULL,
  button_link_2 VARCHAR(255) DEFAULT NULL,
  video_url VARCHAR(255) DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE courses (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  image VARCHAR(255) NOT NULL,
  duration VARCHAR(100) NOT NULL,
  eligibility VARCHAR(255) NOT NULL,
  fees VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  career_opportunities TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE placements (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  recruiter_name VARCHAR(200) NOT NULL,
  logo VARCHAR(255) NOT NULL,
  package_details VARCHAR(255) NOT NULL,
  placement_statistics TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE recruiters (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  logo VARCHAR(255) DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE events (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  event_date DATE NOT NULL,
  banner VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE blog_categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE blogs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  category_id INT UNSIGNED DEFAULT NULL,
  featured_image VARCHAR(255) NOT NULL,
  content LONGTEXT NOT NULL,
  seo_title VARCHAR(255) DEFAULT NULL,
  seo_description VARCHAR(255) DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL DEFAULT NULL,
  FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE gallery (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  category VARCHAR(100) NOT NULL,
  media_type ENUM('image','video') NOT NULL DEFAULT 'image',
  media_file VARCHAR(255) DEFAULT NULL,
  media_url VARCHAR(255) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE testimonials (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_name VARCHAR(150) NOT NULL,
  course VARCHAR(150) NOT NULL,
  photo VARCHAR(255) NOT NULL,
  rating INT UNSIGNED NOT NULL DEFAULT 5,
  review TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE admissions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  mobile VARCHAR(50) NOT NULL,
  email VARCHAR(150) NOT NULL,
  city VARCHAR(100) NOT NULL,
  state VARCHAR(100) NOT NULL,
  course_interested VARCHAR(255) NOT NULL,
  qualification VARCHAR(255) NOT NULL,
  message TEXT DEFAULT NULL,
  status ENUM('New','Contacted','Interested','Admitted','Rejected') NOT NULL DEFAULT 'New',
  notes TEXT DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE contact_messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(100) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(150) NOT NULL UNIQUE,
  `value` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE seo_settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  page VARCHAR(100) NOT NULL UNIQUE,
  meta_title VARCHAR(255) DEFAULT NULL,
  meta_description VARCHAR(255) DEFAULT NULL,
  meta_keywords VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admins (name, email, password_hash) VALUES
('Admin User', 'admin@example.com', '$2y$10$9XVoivg29ELEHq298P.gMuQRkqfdQnJ95g066ouc42kBtQdP4/L/q');

INSERT INTO blog_categories (name) VALUES
('Industry News'),
('Supply Chain'),
('Student Stories');

INSERT INTO settings (`key`, `value`) VALUES
('site_title','Logistics College Management System - CAIIHM Logistics College'),
('site_description','Premium Logistics & Supply Chain Management College'),
('contact_address','123 Logistics Avenue, City'),
('contact_phone','+1 234 567 890'),
('contact_email','info@logisticscollege.edu'),
('contact_whatsapp','+1234567890'),
('contact_maps','https://www.google.com/maps'),
('chairman_message','Our chairman is committed to delivering global-standard logistics education.'),
('principal_message','Our principal drives academic excellence through industry-led curriculum.'),
('vision_statement','To become a leading destination for logistics and supply chain talent.'),
('mission_statement','Empower students with practical skills and placement-ready training.'),
('infrastructure_description','A modern campus with labs, simulation suites and reinforced learning spaces.'),
('industry_partnerships','Trusted by logistics leaders, freight firms, and logistics technology providers.'),
('hero_button_text_1','Apply Now'),
('hero_button_link_1','pages/admissions.php'),
('hero_button_text_2','Download Brochure'),
('hero_button_link_2','pages/contact.php');

INSERT INTO seo_settings (page, meta_title, meta_description, meta_keywords) VALUES
('home','Logistics College | Home','Modern logistics and supply chain management college.','logistics, supply chain, college, education'),
('about','About Us | Logistics College','Learn about our mission, vision and campus infrastructure.','about, mission, vision, logistics college'),
('courses','Courses | Logistics College','Explore logistics and supply chain management courses.','courses, logistics, supply chain'),
('placements','Placements | Logistics College','Discover our placement success and recruiter partners.','placements, recruiters, salary'),
('events','Events | Logistics College','View upcoming campus events and industry workshops.','events, workshops, campus'),
('gallery','Gallery | Logistics College','See our campus life, workshops and industry visits.','gallery, campus, events'),
('blog','Blog | Logistics College','Read logistics industry insights and student stories.','blog, logistics, education'),
('admissions','Admissions | Logistics College','Apply for logistics and supply chain programs.','admissions, apply, logistics college'),
('contact','Contact | Logistics College','Get in touch with our admissions and campus team.','contact, logistics college');

INSERT INTO courses (name, image, duration, eligibility, fees, description, career_opportunities) VALUES
('Diploma in Logistics Management','course1.svg','1 Year','10+2 in any stream','$6,000','A practical diploma in logistics operations, transportation and warehousing management.','Roles in warehousing, transport planning, inventory control.'),
('Advanced Supply Chain Program','course2.svg','6 Months','Graduate in any discipline','$8,500','A specialized program to build strategic supply chain capabilities and SCM analytics.','Careers in procurement, supply planning, and distribution.'),
('Freight & Transport Management','course3.svg','9 Months','10+2 with maths','$7,200','Training for freight forwarding, transport laws and multimodal logistics.','Jobs in freight forwarding, customs brokerage, transport management.'),
('Logistics Technology & Analytics','course4.svg','1 Year','Graduate with interest in logistics','$9,000','A modern course on logistics IT, operations research and analytics-driven supply chain.','Careers in logistics analytics, ERP support, operations management.');

INSERT INTO placements (recruiter_name, logo, package_details, placement_statistics) VALUES
('Global Freight LLP','event1.svg','Average package $32,000','95% placement rate in logistics roles'),
('SupplyChain Nexus','event2.svg','Highest package $42,000','Strong campus recruitment across warehousing and transit.');

INSERT INTO events (title, event_date, banner, description) VALUES
('Industry 4.0 Logistics Workshop','2026-08-15','event1.svg','A hands-on workshop on digital logistics and warehousing automation.'),
('Career Orientation Session','2026-09-05','event2.svg','An interactive event featuring recruiters from leading supply chain companies.');

INSERT INTO blogs (title, slug, category_id, featured_image, content, seo_title, seo_description) VALUES
('Why Logistics is the Career of the Future','why-logistics-is-the-career-of-the-future',1,'blog1.svg','<p>Logistics is a fast-growing field with strong demand across e-commerce, manufacturing and retail.</p>','Why Logistics is the Career of the Future','Learn why logistics and supply chain careers are in high demand.'),
('Top Industry Skills for Supply Chain Managers','top-industry-skills-for-supply-chain-managers',2,'blog2.svg','<p>Supply chain managers need analytical, digital and leadership skills to succeed in modern operations.</p>','Top Industry Skills for Supply Chain Managers','Discover key skills promoted by logistics employers.');

INSERT INTO gallery (title, category, media_type, media_file, description) VALUES
('Campus Learning Center','Campus','image','gallery1.svg','Students learning in our logistics simulation labs.'),
('Warehouse Visit','Industrial Visits','image','gallery1.svg','Hands-on visit to a distribution center.');

INSERT INTO testimonials (student_name, course, photo, rating, review) VALUES
('Anika Sharma','Diploma in Logistics Management','gallery1.svg',5,'The college helped me transition into a logistics career with strong practical exposure.');

INSERT INTO admissions (name, mobile, email, city, state, course_interested, qualification, message, status, notes) VALUES
('Rohan Patel','+1 555 123 4567','rohan.patel@example.com','Lagos','State','Diploma in Logistics Management','12th Pass','Interested in career placement support.','New','');

INSERT INTO contact_messages (name, email, phone, subject, message) VALUES
('Priya Singh','priya.singh@example.com','+1 555 765 4321','Request brochure','Please send me the admissions brochure for logistics programs.');
