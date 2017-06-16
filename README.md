# ranch

**RANCH IS A WORK IN PROGRESS**

Ranch is a command line tool that helps you manage your sites in Homestead.

## Overview

```
ranch [command] [args]
```

|  |  |  |
|:--|:--|:--
|`sites`| List all your sites | ✅ |
|`validate`| Validate your environment | ✅ |
|`add`| Add a new site to your configuration | ⏳ |
|`remove`| List all your sites | ⏳ |
|`init`| Create or reset your `.ranchcfg` file | ⏳ |

### Configuration

The `.ranchcfg` file will be expected to be in the users home directory and will contain some basic settings like:

* Homestead IP address
* Homestead.yaml file location
* Preferences for automatic reprovisioning

You can use using `ranch init` or create it manually. You'll have to manually fill it. Here is an example with all the possible config values:

**`~/.ranchcfg`**
```
HOMESTEAD_DIR=/home/johndoe/Homestead
HOMESTEAD_IP=192.168.10.10
HOSTS_FILE=/etc/hosts
```

**Note:** if you don't configure any values, the following default values will be used:
| key | value |
|:--|:--|
| `HOMESTEAD_DIR` | `$HOME/Homestead` |
| `HOMESTEAD_IP` | `192.168.10.10` |
| `HOSTS_FILE` | `/etc/hosts` |
