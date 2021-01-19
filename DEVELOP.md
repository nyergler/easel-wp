# Developing Easel

Easel is a WordPress plugin that provides opinionated portfolio management.

This document contains instructions for working _on_ Easel. If you simply wish
to use Easel to manage your portfolio, see the [user documentation](./USER.md).

## Setting up Your Environment

Easel requires a working Node environment to manage build scripts.

In your Easel directory, install the dependencies:

```shell
$ yarn
```

You can start a Docker container with WordPress & Easel installed using
[wp-env](https://www.npmjs.com/package/@wordpress/env).

```shell
$ yarn wp-env start
yarn run v1.22.10
$ wp-env start
✔ WordPress started at http://localhost:8888/. (in 79s 872ms)
✨  Done in 80.35s.
```

After the command completes, you can visit your development WordPress
installation at [`http://localhost:8888`](http://localhost:8888).

The default username & password will be `admin` / `password`.

