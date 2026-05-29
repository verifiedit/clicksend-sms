# CLAUDE.md

Guidance for Claude Code when working in this repository. This file is self-contained — do not rely on `readme.md` for build commands.

## Project

Lightweight ClickSend SMS API SDK — published as `verifiedit/clicksend-sms` (`type: library`) and consumed by `verifiedit/laravel-notification-channel-clicksend` and other Verified packages.

## Stack

- **Language:** PHP `>=8.3`
- **Package manager:** Composer
- **HTTP client:** Guzzle `^7.4.5`
- **Laravel compatibility:** `illuminate/collections` 10 / 11 / 12 / 13 (collections only — not a Laravel package)
- **Tests:** PHPUnit `^12.5`
- **Style / static analysis:** none configured (no Pint / PHPStan)

## Commands

This is a library — no app to boot:

```shell
composer install
composer run test                     # PHPUnit
composer run test:coverage            # PHPUnit + clover coverage
```

There are no lint, static-analysis, or hook scripts defined.

## Before declaring a task complete

Run `composer run test` and fix every failure.

## Layout

```
src/                                 # Verifiedit\ClicksendSms\* — SDK source
tests/                               # PHPUnit tests
CHANGELOG.md                         # Hand-maintained release notes
```

## Conventions

- **Commits / PRs:** match recent style (`feat:`, `fix:`, `chore:`) and tag releases with semver.
- **PR reviewers:** `verifiedit/dev` (no `CODEOWNERS`).
- **Public API stability.** Consumed by `clicksend` and downstream apps — breaking signatures requires a major version bump.
- **Keep dependencies minimal.** Only Guzzle and `illuminate/collections` should be runtime deps.
- **Type everything** on public methods.
- **Tests are mandatory** for new public methods.

## Releasing

- Tag with semver (`vX.Y.Z`). Update `CHANGELOG.md`.
- Bump the dependency in `clicksend` (and any other consumers) via a separate PR.

## Things to avoid

- Adding Laravel framework dependencies (this is intentionally framework-light).
- Bumping the PHP minimum without consumer coordination.
- Committing `vendor/` or `.phpunit.result.cache`.

## Skills

- `/code-review`, `/review`, `/security-review`, `/simplify`, `/init`.
