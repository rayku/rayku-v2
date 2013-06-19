set :application, "Rayku"
set :domain,      "198.101.199.107"
set :deploy_to,    "/var/rayku.com"

set :repository,  "git@github.com:rayku/rayku-v2.git"
set :scm,         :git

role  :web,           domain
role  :app,           domain, :primary => true

set :model_manager, "doctrine"
set :use_composer, true
set :keep_releases,  3

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

## Nice options to add
# set :composer_options,        "--prefer-source"
ssh_options[:forward_agent] = true

set :branch, "dev-branch"
set :git_enable_submodules, 1
set :use_sudo, false
set :user, "donny"
# set :dump_assetic_assets, true

set :shared_files,            ["app/config/parameters.yml"]
set :assets_symlinks,         true
set :shared_children, [app_path + "/logs", app_path + "/sessions", web_path + "/uploads", "vendor"]
# set :clear_controllers,       false

# before 'symfony:cache:warmup', 'symfony:doctrine:migrations:migrate'
before 'symfony:composer:install', 'composer:copy_vendors'
before 'symfony:composer:update', 'composer:copy_vendors'

namespace :deploy do
	# Apache needs to be restarted to make sure that the APC cache is cleared.
	# This overwrites the :restart task in the parent config which is empty.
	desc "Restart Apache"
	task :restart, :except => { :no_release => true }, :roles => :app do
		run "sudo service apache2 restart"
		puts "--> Apache successfully restarted".green
	end
end

namespace :composer do
  task :copy_vendors, :except => { :no_release => true } do
    capifony_pretty_print "--> Copy vendor file from previous release"

    run "vendorDir=#{current_path}/vendor; if [ -d $vendorDir ] || [ -h $vendorDir ]; then cp -a $vendorDir #{latest_release}/vendor; fi;"
    capifony_puts_ok
  end
end

# # configure production settings
# task :production do
#     set :stage,     "production"
#     set :deploy_to, "/usr/local/web/htdocs/org.sonata-project"
#
#     role :app,      'wwww-data@sonata-project.org', :master => true, :primary => true
#     # role :app,      'wwww-data@sonata-project.org'
#
#     role :web,      'wwww-data@sonata-project.org', :master => true, :primary => true
#     # role :web,      'wwww-data@sonata-project.org'
#
#     role :db,       "wwww-data@db.sonata-project.org", :primary => true, :no_release => true
# end
#
# # configure validation settings
# task :validation do
#     set :stage,     "validation"
#     set :deploy_to, "/usr/local/web/htdocs/org.sonata-project.validation"
#
#     role :app,      'wwww-data@validation.sonata-project.org', :master => true, :primary => true
#     # role :app,      'wwww-data@sonata-project.org'
#
#     role :web,      'wwww-data@validation.sonata-project.org', :master => true, :primary => true
#     # role :web,      'wwww-data@sonata-project.org'
#
#     role :db,       "wwww-data@db.validation.sonata-project.org", :primary => true, :no_release => true
#
#     set :sonata_page_managers, ['page', 'snapshot']
# end