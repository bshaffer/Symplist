CREATE TABLE cs_navigation_item (id BIGINT AUTO_INCREMENT, name VARCHAR(255), route VARCHAR(255), protected TINYINT(1) DEFAULT '0', locked TINYINT(1) DEFAULT '0', root_id INT, lft INT, rgt INT, level SMALLINT, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE cs_navigation_menu (id BIGINT AUTO_INCREMENT, title VARCHAR(255), description VARCHAR(255), root_id BIGINT, INDEX root_id_idx (root_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE keyword (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE seo_page (id BIGINT AUTO_INCREMENT, url VARCHAR(255), title VARCHAR(255), description LONGTEXT, keywords VARCHAR(255), priority DECIMAL(18,1) DEFAULT 0.5, changefreq VARCHAR(255) DEFAULT 'weekly', exclude_from_sitemap TINYINT(1) DEFAULT '0', created_at DATETIME, updated_at DATETIME, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE plugin_author (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255), last_name VARCHAR(255), email VARCHAR(255), bio LONGTEXT, sf_guard_user_id INT, INDEX sf_guard_user_id_idx (sf_guard_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE plugin_category (id BIGINT AUTO_INCREMENT, name VARCHAR(255), description LONGTEXT, slug VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE plugin_rating (id BIGINT AUTO_INCREMENT, symfony_plugin_id BIGINT, sf_guard_user_id INT, rating BIGINT, created_at DATETIME, updated_at DATETIME, INDEX symfony_plugin_id_idx (symfony_plugin_id), INDEX sf_guard_user_id_idx (sf_guard_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE comment (id BIGINT AUTO_INCREMENT, body LONGTEXT, approved TINYINT(1) DEFAULT '0', approved_at DATETIME, user_id BIGINT, authenticated_user_id INT, root_id INT, lft INT, rgt INT, level SMALLINT, created_at DATETIME, updated_at DATETIME, INDEX user_id_idx (user_id), INDEX authenticated_user_id_idx (authenticated_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE commenter (id BIGINT AUTO_INCREMENT, username VARCHAR(255), email VARCHAR(255), website VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id INT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME, updated_at DATETIME, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id INT, permission_id INT, created_at DATETIME, updated_at DATETIME, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id INT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME, updated_at DATETIME, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id INT AUTO_INCREMENT, user_id INT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME, updated_at DATETIME, INDEX user_id_idx (user_id), PRIMARY KEY(id, ip_address)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id INT AUTO_INCREMENT, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME, updated_at DATETIME, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id INT, group_id INT, created_at DATETIME, updated_at DATETIME, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id INT, permission_id INT, created_at DATETIME, updated_at DATETIME, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
CREATE TABLE symfony_plugin_comment (id BIGINT, comment_id BIGINT, PRIMARY KEY(id, comment_id)) ENGINE = INNODB;
CREATE TABLE symfony_plugin (id BIGINT AUTO_INCREMENT, title VARCHAR(255) NOT NULL UNIQUE, description LONGTEXT, user_id INT, symfony_developer VARCHAR(255), category_id BIGINT, active TINYINT(1), repository VARCHAR(255), image VARCHAR(255), homepage VARCHAR(255), ticketing VARCHAR(255), slug VARCHAR(255), created_at DATETIME, updated_at DATETIME, INDEX user_id_idx (user_id), INDEX category_id_idx (category_id), PRIMARY KEY(id)) ENGINE = INNODB;
ALTER TABLE cs_navigation_menu ADD FOREIGN KEY (root_id) REFERENCES cs_navigation_item(id);
ALTER TABLE plugin_author ADD FOREIGN KEY (sf_guard_user_id) REFERENCES sf_guard_user(id);
ALTER TABLE plugin_rating ADD FOREIGN KEY (symfony_plugin_id) REFERENCES symfony_plugin(id) ON DELETE CASCADE;
ALTER TABLE plugin_rating ADD FOREIGN KEY (sf_guard_user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE comment ADD FOREIGN KEY (user_id) REFERENCES commenter(id);
ALTER TABLE comment ADD FOREIGN KEY (authenticated_user_id) REFERENCES sf_guard_user(id);
ALTER TABLE sf_guard_group_permission ADD FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE symfony_plugin_comment ADD FOREIGN KEY (id) REFERENCES symfony_plugin(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE symfony_plugin_comment ADD FOREIGN KEY (comment_id) REFERENCES comment(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE symfony_plugin ADD FOREIGN KEY (user_id) REFERENCES sf_guard_user(id);
ALTER TABLE symfony_plugin ADD FOREIGN KEY (category_id) REFERENCES plugin_category(id);
