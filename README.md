# check-plugins-bash-script

This will print the last updated date for each installed plugin. Note that this script assumes that you're in the WordPress root directory where the wp command works.

## Requirements:

WP-CLI installed and accessible via wp.

jq for parsing JSON. Install it via ```sudo apt install jq```

curl for making HTTP requests. 

Install it via ```sudo apt install curl```

## Steps to Run the Script:

Save the above script in a file, called get_plugins_last_updated.sh.

Make the script executable:

```chmod +x get_plugins_last_updated.sh```

Run the script:

```
sudo -u www-data ./get_plugins_last_updated.sh
```
