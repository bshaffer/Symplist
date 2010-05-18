# =============================================================================
# REQUIRED VARIABLES
# =============================================================================
set :application, "symplist.net"
set :domain, "symplist.net"
set :server_path, "/var/www"
set :deploy_to, "#{server_path}/#{application}"
set :symfony_lib, "/usr/local/lib/symfony"

# =============================================================================
# SCM OPTIONS
# =============================================================================
set :scm, :git
set :scm_user, 'bshaffer'
set :repository, "git://github.com/bshaffer/Symplist.git"
set :git_enable_submodules, 1

# =============================================================================
# SSH OPTIONS
# =============================================================================
set :user, 'brent'
set :use_sudo, false

# =============================================================================
# ROLES
# =============================================================================
# Modify these values to execute tasks on a different server.
role :web, domain
role :app, domain
role :db,  domain, :primary => true
