module.exports = {
  base: '/preflight-command/',
  title: 'WP Preflight Command',
  description: 'Check for common WordPress mistakes & enforce best practices before take off',
  themeConfig: {
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Quick Start', link: '/quick-start/' },
      { text: 'Config', link: '/config/' },
      { text: 'Commands', link: '/commands/' },
      { text: 'Checkers', link: '/checkers/' },
      { text: 'Itineris', link: 'https://itineris.co.uk' },
    ],
    // sidebar: 'auto',
    sidebar: [
      '/',
      '/quick-start/',
      '/config/',
      '/commands/',
      '/checkers/',
    ],
    lastUpdated: 'Last Updated',
    repo: 'ItinerisLtd/preflight-command',
    docsDir: 'docs',
    editLinks: true,
    editLinkText: 'Edit this page on GitHub!'
  }
}
