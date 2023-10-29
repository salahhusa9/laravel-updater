const withMarkdoc = require('@markdoc/next.js')

/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  pageExtensions: ['js', 'jsx', 'md'],
  images: {
    unoptimized: true,
  },
  experimental: {
    scrollRestoration: true,
  },
  // change base path of assets in call: i host in github pages in salahhusa9.github.io/laravel-updater but assets are in salahhusa9.github.io/laravel-updater/_next
  assetPrefix: process.env.NODE_ENV === 'production' ? '/laravel-updater/' : '',
  basePath: process.env.NODE_ENV === 'production' ? '/laravel-updater' : '',

}

module.exports = withMarkdoc()(nextConfig)
