const withMarkdoc = require('@markdoc/next.js')

/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  pageExtensions: ['js', 'jsx', 'md'],
  experimental: {
    scrollRestoration: true,
  },
  images: {
    unoptimized: true,
  },
  assetPrefix: process.env.NODE_ENV === 'production' ? '/laravel-updater/' : '',
  basePath: process.env.NODE_ENV === 'production' ? '/laravel-updater' : '',
}

module.exports = withMarkdoc()(nextConfig)
