# GitHub Copilot Chat

- Extension Version: 0.32.0 (prod)
- VS Code: vscode/1.105.0
- OS: Linux
- Remote Name: codespaces

## Network

User Settings:
```json
  "github.copilot.advanced.debug.useElectronFetcher": false,
  "github.copilot.advanced.debug.useNodeFetcher": false,
  "github.copilot.advanced.debug.useNodeFetchFetcher": false
```

Connecting to <https://api.github.com>:
- DNS ipv4 Lookup: 20.205.243.168 (5 ms)
- DNS ipv6 Lookup: Error (15 ms): getaddrinfo ENOTFOUND api.github.com
- Proxy URL: None (118 ms)
- Electron fetch: Unavailable
- Node.js https: HTTP 200 (139 ms)
- Node.js fetch (configured): HTTP 200 (440 ms)

Connecting to https://api.individual.githubcopilot.com/_ping:
- DNS ipv4 Lookup: 140.82.112.21 (3 ms)
- DNS ipv6 Lookup: Error (3 ms): getaddrinfo ENOTFOUND api.individual.githubcopilot.com
- Proxy URL: None (102 ms)
- Electron fetch: Unavailable
- Node.js https: HTTP 200 (824 ms)
- Node.js fetch (configured): HTTP 200 (340 ms)

## Documentation

In corporate networks: [Troubleshooting firewall settings for GitHub Copilot](https://docs.github.com/en/copilot/troubleshooting-github-copilot/troubleshooting-firewall-settings-for-github-copilot).