# Security Policy

## Reporting a Vulnerability

If you discover a security vulnerability in this project, please **do not** report it through public issues, pull requests, or public discussion.

Instead, report it privately to the project maintainer with the maximum detail possible.

Include, if possible:

- Type of issue (for example: authentication bypass, exposure of secrets, SQL injection, XSS, insecure file handling, broken access control).
- Affected file(s), route(s), module(s), or feature(s).
- Clear step-by-step reproduction instructions.
- Impact of the issue.
- Proof of concept, logs, screenshots, or payload examples when safe to share.
- Suggested mitigation, if known.

## What to avoid

To protect users and the project, please do not:

- Open a public issue describing the vulnerability before coordination.
- Share secrets, tokens, credentials, or private user data in reports.
- Test aggressively against production systems.
- Use destructive payloads or actions that can damage data or availability.

## Initial response policy

The maintainer will review the report, validate the issue, assess severity, and define the remediation path.

When appropriate, the process should follow this order:

1. Confirm receipt of the report.
2. Reproduce and validate the vulnerability.
3. Prepare and test a fix.
4. Deploy the fix or publish the patch.
5. Disclose the issue publicly only after mitigation is available, when disclosure makes sense.

## Security posture for this repository

This project should follow these baseline practices:

- Never commit secrets, API keys, private tokens, or credential files.
- Use environment variables for sensitive values.
- Validate inputs on all external boundaries.
- Apply least privilege to integrations and credentials.
- Review authentication, authorization, and file upload flows carefully.
- Prefer small, reviewable changes for security-sensitive code.

## Scope

This policy applies to vulnerabilities affecting:

- Source code in this repository.
- Configurations shipped with the project.
- Authentication, authorization, session, token, and data access flows.
- Infrastructure-as-code or deployment configuration stored in the repository.

Thank you for reporting vulnerabilities responsibly.
