# Changelog

## 1.1.2

### Changed
- Prefer `CF-Connecting-IP` over `X-Real-IP` when determining the visitor IP.
  - When present, `CF-Connecting-IP` is now used to populate the `Prepr-Visitor-IP` header.
  - Falls back to `X-Real-IP` if the Cloudflare header is not available.
