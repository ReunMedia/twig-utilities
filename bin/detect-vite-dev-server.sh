#!/bin/sh

# This script detects if Vite dev server is running and stores the running
# server URL to `VITE_DEV_SERVER_URL` environment variable. If the server is not
# running, the variable is set to an empty string.
#
# The script must be sourced to allow it to set ENV variable tha PHP process can
# read.
#
# Example:
#   . ./detect-vite-server.sh && detect_vite localhost:5173 && php -S ...
#
# Example with multiple hosts:
#   ... detect_vite firsthost:5173 secondhost:5173 && php -S ...
#

# Developer notes
#
# - Adding this script to `bin` in `composer.json` doesn't work, since you
#   apparently cannot source scripts from `vendor/bin`

detect_vite() {
  VITE_DEV_SERVER_URL=""

  echo "Detecting Vite dev server"

  for HOST in "$@"; do
    echo "Looking for Vite at '$HOST'"

    # Split input into HOSTNAME and PORT
    HOSTNAME=$(echo "${HOST}" | cut -d':' -f1)
    PORT=$(echo "${HOST}" | cut -d':' -f2)

    # Resolve hostname to IP with max 1 second timeout and no retries
    IP=$(dig +tries=1 +time=1 +short "${HOSTNAME}")

    # If host was not found, skip pinging the server and try the next host
    HOST_FOUND=$?
    if [ $HOST_FOUND -ne 0 ]; then
      echo "Host not found"
      continue
    fi

    # Use netcat with previously resolved IP without DNS lookup to see if Vite
    # is up at this host
    if nc -vzn "${IP}" "${PORT}" >/dev/null 2>&1; then
      VITE_DEV_SERVER_URL="${HOSTNAME}:${PORT}"
      echo "Vite up"
      # Skip additional hosts if one is up
      break
    fi

    echo "Vite not up"
  done

  if [ -z "${VITE_DEV_SERVER_URL}" ]; then
    echo "Vite dev server is not running. Using latest static build for frontend assets."
  else
    echo "Vite dev server is running at ${VITE_DEV_SERVER_URL}. Using it to serve frontend assets."
  fi

  # Save detection result to env variable so it can be read in PHP later
  export VITE_DEV_SERVER_URL
}
