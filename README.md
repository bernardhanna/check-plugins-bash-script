# check-plugins-bash-script
Requirements:
WP-CLI installed and accessible via wp.
jq for parsing JSON. Install it via sudo apt install jq or the package manager of your choice.
curl for making HTTP requests. Install it via sudo apt install curl or the package manager of your choice.
Steps to Run the Script:
Save the above script in a file, say get_plugins_last_updated.sh.

Make the script executable:

bash
Copy code
chmod +x get_plugins_last_updated.sh
Run the script:

bash
Copy code
sudo -u www-data ./get_plugins_last_updated.sh
This will print the last updated date for each installed plugin. Note that this script assumes that you're in the WordPress root directory where the wp command works.
