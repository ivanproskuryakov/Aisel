#Servers
set :application, "aisel"
set :domain,      "sandox.aisel.co"
set :deploy_to,   "/var/www/sandbox.aisel.co/public"
set :app_path,    "app"
role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations will run
set  :keep_releases,  3
logger.level = Logger::INFO
 
#Run options
set :user,        "root"
set :use_sudo,     false
ssh_options[:keys] = "/Users/invoice/.ssh/known_hosts"
ssh_options[:forward_agent] = true
default_run_options[:pty] = true
 
#Repository
set :repository,  "https://volgodark@bitbucket.org/volgodark/projectx.git"
set :scm,         :git
set :deploy_via, :remote_cache
 
#Symfony
set :writable_dirs,     [app_path + "/cache"]
set :webserver_user,    "www-data"
set :permission_method, :acl
set :use_set_permissions, true
set :shared_files, ["app/config/parameters.yml"]
set :use_composer, true
set :composer_options, "--prefer-source"
set :copy_vendors, true
set :dump_assetic_assets, true
set :model_manager, "doctrine"
 
 
#set :clear_controllers, false
 
#Custom tasks
namespace :deploy do
 desc "Update bootstrap symlink"
  task :bootstrap_symlink do
    run("cd #{release_path} && php app/console mopa:bootstrap:symlink:less")
  end
end
 
before 'symfony:assetic:dump', 'deploy:bootstrap_symlink'