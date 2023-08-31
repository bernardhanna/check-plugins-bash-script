#!/bin/bash

# Get a list of all installed plugins
plugins=$(wp plugin list --field=name)

# Loop through each plugin and fetch its last updated date
for plugin in $plugins; do
  echo "Fetching info for plugin: $plugin"
  
  # Fetch plugin info from WordPress.org API
  plugin_info=$(curl -s "https://api.wordpress.org/plugins/info/1.0/${plugin}.json")
  
  # Extract the last updated date
  last_updated=$(echo $plugin_info | jq -r '.last_updated')
  
  if [ "$last_updated" != "null" ]; then
    echo "Last updated on: $last_updated"
  else
    echo "Failed to fetch plugin info."
  fi
  
  echo "-------------------------"
done
