# Cloudflared for unRAID
Install and manage the official Cloudflare `cloudflared` client on unRAID via Community Applications.

## Why run cloudflared on unRAID
- Publish unRAID services without opening inbound ports, NAT, or exposing your WAN IP.
- Provides continuous access even if your unRAID array stopped, no need for dockers or VMs.
- Put Cloudflare’s DDoS protection, WAF, and identity-aware Zero Trust in front of your apps.
- Access internal services and SMB/NFS shares securely over private tunnels from anywhere.

## What this plugin provides
- Installs the official `cloudflared` binary and persists it across reboots.
- Provides a basic web UI to configure cloudflared settings that persist across reboots.
- Designed to work with Community Applications updates.

Note: This plugin focuses on installation and launching `cloudflared`. You are still expected to set up configuration
files as needed, aided by the `cloudflared` CLI. See the set-up instructions on 
[cloudflare](https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/do-more-with-tunnels/local-management/).

## High-level cloudflared features now possible
- Tunnels to Cloudflare:
  - HTTP(S) reverse proxy to publish web UIs on custom domains.
  - Private network routing over Cloudflare Zero Trust as an alternative to Wireguard or Tailscale.
  - Also works for servers with dynamic IPs or behind CGNAT.
- Zero Trust access:
  - Enforce SSO (Okta, Google, Azure AD, GitHub, etc.) before reaching your services.
  - Device posture, mTLS, and per-resource policies.
- Built-in helpers:
  - `proxy-dns` for a lightweight DNS over HTTPS forwarder.
  - TCP/SSH/RDP access via Cloudflare Access.
  - QUIC transport for better performance on lossy networks.

## License and acknowledgments
- `cloudflared` is provided by Cloudflare under its own license.