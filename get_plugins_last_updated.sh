#!/bin/bash

# Temporary file to store plugin info
temp_file=$(mktemp)

# Variable to store plugins that failed to fetch info
failed_plugins=""

# Get a list of all installed plugins
plugins=$(wp plugin list --field=name)

# Get today's date
today=$(date +%Y-%m-%d)

# Loop through each plugin and fetch its last updated date
for plugin in $plugins; do
  echo "Fetching info for plugin: $plugin"
  
  # Fetch plugin info from WordPress.org API
  plugin_info=$(curl -s "https://api.wordpress.org/plugins/info/1.0/${plugin}.json")
  
  # Extract the last updated date (only the date part)
  last_updated=$(echo $plugin_info | jq -r '.last_updated' | cut -d ' ' -f 1)
  
  if [ "$last_updated" != "null" ]; then
    echo "$last_updated $plugin" >> $temp_file
  else
    echo "Failed to fetch plugin info."
    failed_plugins="$failed_plugins $plugin,"
  fi
  
  echo "-------------------------"
done

# Sort the temporary file by date and print the sorted plugins
sort $temp_file | while read -r line; do
  date=$(echo $line | awk '{print $1}')
  plugin=$(echo $line | awk '{print substr($0, index($0,$2))}')

  # Calculate the number of days since the last update
  days_since_update=$(( ( $(date -d "$today" +%s) - $(date -d "$date" +%s) ) / 86400 ))

  # Check if the plugin has been updated in the last 6 months (approx. 182 days)
  if [ "$days_since_update" -gt 182 ]; then
    echo -e "\e[31mWarning\e[0m: $plugin, Last Updated on: $date"
  else
    echo -e "\e[32mOK\e[0m: $plugin, Last Updated on: $date"
  fi
done

# Remove the temporary file
rm $temp_file

# Print plugins that failed to fetch info
if [ ! -z "$failed_plugins" ]; then
  echo "Failed to get last update information for the following plugins: ${failed_plugins%,} This could be because the plugin is not hosted on WordPress.org, it could be Premium, has been removed or is a custom plugin."
fi
