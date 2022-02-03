# Development under VM container

Developing hello-php under VM such as docker

## Features
- It has VSCode's Ruby extension pack
- Solargraph
- Rubocop
- Supports Apple Silicon machines

## Requirements

### Visual Studio Code

Including the following extensions:

- [Docker](https://marketplace.visualstudio.com/items?itemName=ms-azuretools.vscode-docker)
- [Remote - Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers)

## Caveats/Conditions

### Windows' WSL

Setting up your development container under WSL is just easy,
as long as you are using the official Ubuntu distro installed from Windows Store.
Also, install this following [extension](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-wsl) for your VSCode

### MacOS (Intel CPUs)

Same as Windows' WSL

### MacOS (Apple Silicon / M1 / M2)

Same as MacOS (Intel), but this one has a different CPU architecture, so experiment on your own

## Setup

1. Open the current project directory
2. Press Ctrl+P or Command+P
3. Type `> Remote Containers: Rebuild and Reopen in Container` then enter
<br>NOTE: This command includes the `>` character
4. And wait for the magic happening...
