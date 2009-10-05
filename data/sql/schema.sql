CREATE TABLE comment (id BIGINT AUTO_INCREMENT, body LONGTEXT, approved TINYINT(1) DEFAULT '0', approved_at DATETIME, user_id BIGINT, authenticated_user_id INT, root_id BIGINT, lft INT, rgt INT, level SMALLINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), INDEX authenticated_user_id_idx (authenticated_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE commenter (id BIGINT AUTO_INCREMENT, username VARCHAR(255), email VARCHAR(255), website VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE community_list (id BIGINT AUTO_INCREMENT, title VARCHAR(255) NOT NULL, description VARCHAR(255), featured TINYINT(1), submitted_by INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), description_html LONGTEXT, INDEX submitted_by_idx (submitted_by), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE community_list_item (id BIGINT AUTO_INCREMENT, title VARCHAR(255) NOT NULL, body LONGTEXT, list_id BIGINT, score BIGINT DEFAULT 0, count BIGINT DEFAULT 0, submitted_by INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, body_html LONGTEXT, INDEX list_id_idx (list_id), INDEX submitted_by_idx (submitted_by), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE keyword (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE plugin_author (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255), last_name VARCHAR(255), email VARCHAR(255), bio LONGTEXT, sf_guard_user_id INT, INDEX sf_guard_user_id_idx (sf_guard_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE plugin_category (id BIGINT AUTO_INCREMENT, name VARCHAR(255), description LONGTEXT, slug VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE plugin_rating (id BIGINT AUTO_INCREMENT, symfony_plugin_id BIGINT, sf_guard_user_id INT, rating BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX symfony_plugin_id_idx (symfony_plugin_id), INDEX sf_guard_user_id_idx (sf_guard_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE plugin_release (id BIGINT AUTO_INCREMENT, plugin_id BIGINT, version VARCHAR(10), date DATETIME, symfony_version_min DECIMAL(5,1), symfony_version_max DECIMAL(5,1), summary LONGTEXT, stability VARCHAR(30), readme LONGTEXT, dependencies VARCHAR(255), INDEX plugin_id_idx (plugin_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE seo_page (id BIGINT AUTO_INCREMENT, url VARCHAR(255), title VARCHAR(255), description LONGTEXT, keywords VARCHAR(255), priority DECIMAL(18,1) DEFAULT 0.5, changefreq VARCHAR(255) DEFAULT 'weekly', exclude_from_sitemap TINYINT(1) DEFAULT '0', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE symfony_plugin_comment (id BIGINT, comment_id BIGINT, PRIMARY KEY(id, comment_id)) ENGINE = INNODB;
CREATE TABLE symfony_plugin (id BIGINT AUTO_INCREMENT, title VARCHAR(255) NOT NULL UNIQUE, description LONGTEXT, user_id INT, symfony_developer VARCHAR(255), category_id BIGINT, active TINYINT(1), repository VARCHAR(255), image VARCHAR(255), homepage VARCHAR(255), ticketing VARCHAR(255), slug VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), INDEX category_id_idx (category_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE cs_navigation_item (id BIGINT AUTO_INCREMENT, name VARCHAR(255), route VARCHAR(255), protected TINYINT(1) DEFAULT '0', locked TINYINT(1) DEFAULT '0', root_id BIGINT, lft INT, rgt INT, level SMALLINT, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE cs_navigation_menu (id BIGINT AUTO_INCREMENT, title VARCHAR(255), description VARCHAR(255), root_id BIGINT, INDEX root_id_idx (root_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id INT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id INT, permission_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id INT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id INT AUTO_INCREMENT, user_id INT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id, ip_address)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id INT AUTO_INCREMENT, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id INT, group_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id INT, permission_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_setting (id INT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, type VARCHAR(255), options TEXT, value LONGTEXT, PRIMARY KEY(id)) ENGINE = INNODB;
ALTER TABLE comment ADD CONSTRAINT comment_user_id_commenter_id FOREIGN KEY (user_id) REFERENCES commenter(id);
ALTER TABLE comment ADD CONSTRAINT comment_authenticated_user_id_sf_guard_user_id FOREIGN KEY (authenticated_user_id) REFERENCES sf_guard_user(id);
ALTER TABLE community_list ADD CONSTRAINT community_list_submitted_by_sf_guard_user_id FOREIGN KEY (submitted_by) REFERENCES sf_guard_user(id);
ALTER TABLE community_list_item ADD CONSTRAINT community_list_item_submitted_by_sf_guard_user_id FOREIGN KEY (submitted_by) REFERENCES sf_guard_user(id);
ALTER TABLE community_list_item ADD CONSTRAINT community_list_item_list_id_community_list_id FOREIGN KEY (list_id) REFERENCES community_list(id);
ALTER TABLE plugin_author ADD CONSTRAINT plugin_author_sf_guard_user_id_sf_guard_user_id FOREIGN KEY (sf_guard_user_id) REFERENCES sf_guard_user(id);
ALTER TABLE plugin_rating ADD CONSTRAINT plugin_rating_symfony_plugin_id_symfony_plugin_id FOREIGN KEY (symfony_plugin_id) REFERENCES symfony_plugin(id) ON DELETE CASCADE;
ALTER TABLE plugin_rating ADD CONSTRAINT plugin_rating_sf_guard_user_id_sf_guard_user_id FOREIGN KEY (sf_guard_user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE plugin_release ADD CONSTRAINT plugin_release_plugin_id_symfony_plugin_id FOREIGN KEY (plugin_id) REFERENCES symfony_plugin(id);
ALTER TABLE symfony_plugin_comment ADD CONSTRAINT symfony_plugin_comment_id_symfony_plugin_id FOREIGN KEY (id) REFERENCES symfony_plugin(id);
ALTER TABLE symfony_plugin_comment ADD CONSTRAINT symfony_plugin_comment_comment_id_comment_id FOREIGN KEY (comment_id) REFERENCES comment(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE symfony_plugin ADD CONSTRAINT symfony_plugin_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id);
ALTER TABLE symfony_plugin ADD CONSTRAINT symfony_plugin_category_id_plugin_category_id FOREIGN KEY (category_id) REFERENCES plugin_category(id);
ALTER TABLE cs_navigation_menu ADD CONSTRAINT cs_navigation_menu_root_id_cs_navigation_item_id FOREIGN KEY (root_id) REFERENCES cs_navigation_item(id);
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
