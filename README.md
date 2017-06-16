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

### RanchConfig (`.ranchcfg`)

The `.ranchcfg` file will be placed in the users home directory and will contain some basic settings like:

* Homestead IP address
* Homestead.yaml file location
* Preferences for automatic reprovisioning
