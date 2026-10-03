<?php

return [

    'name' => 'Impact Waves',
    'legal_name' => 'Impact Waves Agency',
    'tagline' => "Swift and effective solutions for your company's growth.",
    'description' => 'Performance marketing agency: paid social, PPC, CRO, official TikTok agency accounts and Tier-1 search feed partnerships for the US, EU and Canada.',

    // Public address of the site: canonical URLs, sitemap and robots.txt point
    // here, and any other host (vercel.app, previews) is marked noindex.
    'site_url' => rtrim(env('SITE_URL', 'https://impactwaves.agency'), '/'),

    // Where contact-form leads are delivered. Override with AGENCY_EMAIL on Vercel.
    'email' => env('AGENCY_EMAIL', 'hello@impactwaves.agency'),
    'linkedin' => 'https://www.linkedin.com/company/impact-waves-agency/',

    // Where job applications go. Override with CAREERS_EMAIL on Vercel.
    'careers_email' => env('CAREERS_EMAIL', env('AGENCY_EMAIL', 'hello@impactwaves.agency')),

    // Teams shown on About and Careers. Head counts and the company location
    // are edited in Admin → Company (App\Support\Company).
    'departments' => [
        'media-buying' => ['title' => 'Media Buying', 'icon' => 'megaphone', 'text' => 'Launches, tests and scales campaigns on TikTok, Meta, Google and native every day.'],
        'design' => ['title' => 'Design & Creative', 'icon' => 'sparkles', 'text' => 'Ad creatives, video, landing pages and the visual side of every test.'],
        'tech' => ['title' => 'Tech & Tracking', 'icon' => 'cursor', 'text' => 'Tracking, pixels and CAPI, ad account infrastructure, domains and integrations with feed partners.'],
        'development' => ['title' => 'Development', 'icon' => 'code', 'text' => 'In-house engineers building landing pages, internal tools, automation and reporting.'],
        'partnerships' => ['title' => 'Partnerships & Support', 'icon' => 'lifebuoy', 'text' => 'Account managers who onboard clients and traffic providers and stay their single point of contact.'],
        'recruiting' => ['title' => 'Recruiting & HR', 'icon' => 'users', 'text' => 'Finds and onboards media buyers, designers and engineers as the team grows.'],
    ],

    'employment_types' => ['Full-time', 'Part-time', 'Contract', 'Internship'],

    'markets' => [
        ['code' => 'US', 'name' => 'United States'],
        ['code' => 'EU', 'name' => 'European Union'],
        ['code' => 'CA', 'name' => 'Canada'],
    ],

    'partners' => ['Bodis', 'Tonic', 'Ads.com', 'DomainActive', 'TikTok for Business', 'Meta', 'Google Ads', 'Microsoft Advertising'],

    'feed_partners' => ['Bodis', 'Tonic', 'Ads.com', 'DomainActive'],

    'platforms' => ['TikTok', 'Meta', 'Google', 'Microsoft', 'Snapchat', 'Pinterest', 'Native'],

    // Services, as written in the client's "Our Services" document (2026-10-03).
    'services' => [
        'performance-media-buying' => [
            'meta_title' => 'Performance Media Buying Agency: TikTok, Meta and Search',
            'title' => 'Performance Media Buying',
            'eyebrow' => 'Performance media',
            'icon' => 'megaphone',
            'short' => 'Acquire and scale traffic across TikTok, Meta, Search, and emerging paid channels through continuous testing, advanced tracking, and data-driven campaign optimization.',
            'headline' => 'Performance Media Buying',
            'intro' => 'Acquire and scale traffic across TikTok, Meta, Search, and emerging paid channels through continuous testing, advanced tracking, and data-driven campaign optimization.',
            'platforms' => ['TikTok', 'Meta', 'Search', 'Emerging paid channels'],
            'features' => [
                ['title' => 'Multi-channel acquisition', 'text' => 'Campaigns on TikTok, Meta, Google and Microsoft search, plus new paid channels as they open up.'],
                ['title' => 'Continuous testing', 'text' => 'Structured tests of audiences, bids, placements and offers, so budget moves to what wins.'],
                ['title' => 'Advanced tracking', 'text' => 'Pixel, CAPI and server-side tracking that gives the algorithms clean signal and you numbers you can trust.'],
                ['title' => 'Data-driven optimization', 'text' => 'Budget, bid and structure decisions made on data every day, not once a month.'],
                ['title' => 'Scaling', 'text' => 'Controlled budget growth across accounts and geos without losing efficiency.'],
            ],
        ],
        'creative-engineering' => [
            'meta_title' => 'Creative Engineering and Automation for Paid Traffic',
            'title' => 'Creative Engineering & Automation',
            'eyebrow' => 'Creative engineering',
            'icon' => 'sparkles',
            'short' => 'Turn winning creative patterns into repeatable, automated systems for researching, producing, testing, and scaling high-performance creatives, combining human strategy with AI and automation.',
            'headline' => 'Creative Engineering & Automation',
            'intro' => 'Turn winning creative patterns into repeatable, automated systems for researching, producing, testing, and scaling high-performance creatives, combining human strategy with AI and automation.',
            'platforms' => ['Creative research', 'Production', 'Testing', 'AI and automation'],
            'features' => [
                ['title' => 'Creative research', 'text' => 'Find the hooks, angles and formats that already win in your vertical and geo.'],
                ['title' => 'Production at scale', 'text' => 'Variations of proven concepts produced fast, for every platform and placement.'],
                ['title' => 'Structured creative testing', 'text' => 'Clear tests that find winners quickly and retire fatigued creatives before they cost you.'],
                ['title' => 'AI and automation', 'text' => 'Pipelines that speed up research, production and reporting, guided by human strategy.'],
                ['title' => 'Scaling winners', 'text' => 'Winning patterns rolled out across accounts, channels and markets.'],
            ],
        ],
        'traffic-partnerships' => [
            'meta_title' => 'Traffic Acquisition and Partnerships: Feeds, Publishers and Inventory',
            'title' => 'Traffic Acquisition & Partnerships',
            'eyebrow' => 'Traffic partnerships',
            'icon' => 'globe',
            'short' => 'Discover and scale new feeds, traffic sources, publishers, and unique inventory across global geos and high-value verticals, evaluating traffic quality, scalability, and monetization potential.',
            'headline' => 'Traffic Acquisition & Partnerships',
            'intro' => 'Discover and scale new feeds, traffic sources, publishers, and unique inventory across global geos and high-value verticals, evaluating traffic quality, scalability, and monetization potential.',
            'platforms' => ['Feeds', 'Traffic sources', 'Publishers', 'Unique inventory'],
            'features' => [
                ['title' => 'New feeds and traffic sources', 'text' => 'Access to search feeds and sources that are hard to reach on your own.'],
                ['title' => 'Publisher partnerships', 'text' => 'Long-term relationships with publishers and owners of unique inventory.'],
                ['title' => 'Global geos and verticals', 'text' => 'Traffic across global markets and high-value verticals.'],
                ['title' => 'Traffic quality evaluation', 'text' => 'Every source is checked for quality before it gets budget, and monitored after.'],
                ['title' => 'Scalability and monetization potential', 'text' => 'We look at how far a source can grow and what it can earn, not just today\'s numbers.'],
            ],
        ],
        'rsoc-adx-monetization' => [
            'meta_title' => 'RSOC and AdX Monetization for High-Intent Traffic',
            'title' => 'RSOC & AdX Monetization',
            'eyebrow' => 'Monetization',
            'icon' => 'chart',
            'short' => 'Transform high-intent traffic into scalable revenue through RSOC, AdX, content strategy, and continuous monetization optimization.',
            'headline' => 'RSOC & AdX Monetization',
            'intro' => 'Transform high-intent traffic into scalable revenue through RSOC, AdX, content strategy, and continuous monetization optimization.',
            'platforms' => ['RSOC', 'AdX', 'Content strategy', 'Optimization'],
            'features' => [
                ['title' => 'RSOC monetization', 'text' => 'Related search on content setups with Tier-1 feed partners.'],
                ['title' => 'AdX monetization', 'text' => 'Display revenue through Google Ad Exchange alongside search.'],
                ['title' => 'Content strategy', 'text' => 'Pages and topics built around high-intent queries that monetize well.'],
                ['title' => 'Continuous optimization', 'text' => 'Ongoing work on RPM, RPC and layouts to grow revenue per visitor.'],
                ['title' => 'Compliance and quality', 'text' => 'Setups that keep feed partners happy and accounts healthy.'],
            ],
        ],
        'tiktok-agency' => [
            'meta_title' => 'Official TikTok Agency Partner: Agency Ad Accounts',
            'title' => 'Official TikTok Agency Partner',
            'eyebrow' => 'TikTok agency partnership',
            'icon' => 'bolt',
            'short' => 'As an official TikTok agency partner, we help businesses and media buyers access agency account solutions and TikTok advertising infrastructure designed for scalable campaign operations.',
            'headline' => 'Official TikTok Agency Partner',
            'intro' => 'As an official TikTok agency partner, we help businesses and media buyers access agency account solutions and TikTok advertising infrastructure designed for scalable campaign operations.',
            'cta' => 'Need agency accounts for your campaigns? Let\'s talk.',
            'platforms' => ['Agency accounts', 'TikTok Ads Manager', 'Advertising infrastructure'],
            'features' => [
                ['title' => 'Agency account solutions', 'text' => 'Agency-level TikTok ad accounts for businesses and media buyers.'],
                ['title' => 'Advertising infrastructure', 'text' => 'The account setup and infrastructure needed to run campaigns at scale.'],
                ['title' => 'Official partner support', 'text' => 'Direct channels to TikTok for faster answers on reviews, policies and accounts.'],
                ['title' => 'Scalable campaign operations', 'text' => 'Structures that let you launch and grow many campaigns without friction.'],
                ['title' => 'Media buyer friendly', 'text' => 'Built for teams that buy traffic every day, not just brand advertisers.'],
            ],
        ],
    ],

    // Old service URLs and the service each one now lives under.
    'service_redirects' => [
        'paid-social' => 'performance-media-buying',
        'ppc' => 'performance-media-buying',
        'cro' => 'creative-engineering',
        'search-feeds' => 'rsoc-adx-monetization',
    ],

    // Content hubs. Articles live in resources/content/{key}/{slug}.md.
    'sections' => [
        'guides' => [
            'nav' => 'Guides',
            'title' => 'Media Buying Guides',
            'audience' => 'For media buyers',
            'icon' => 'book',
            'headline' => 'Media buying guides for <span class="text-gradient">search arbitrage</span>, TikTok and paid social',
            'lead' => 'Practical playbooks from a team that buys traffic every day: search arbitrage and RSOC, TikTok agency accounts, tracking, metrics and scaling.',
            'meta_title' => 'Media Buying Guides: Search Arbitrage, RSOC and TikTok Ads',
            'meta_description' => 'Free media buying guides for arbitrage teams: how search arbitrage and RSOC work, TikTok agency accounts, RPC, RPM and ROI metrics, and how to scale.',
        ],
        'traffic-providers' => [
            'nav' => 'Traffic Providers',
            'title' => 'For Traffic Providers',
            'audience' => 'For publishers and traffic owners',
            'icon' => 'globe',
            'headline' => 'Turn your traffic into revenue with <span class="text-gradient">Tier-1 search feeds</span>',
            'lead' => 'Publishers, networks and domain owners: we help you monetize website traffic through Tier-1 search feed partners, with compliant setups and transparent reporting.',
            'meta_title' => 'Monetize Website Traffic with Search Feeds',
            'meta_description' => 'Monetize your website, domain or network traffic with Tier-1 search feed partners. Learn how search feed monetization works and what feed partners expect.',
        ],
        'news' => [
            'nav' => 'News',
            'title' => 'News',
            'audience' => 'Agency and industry updates',
            'icon' => 'newspaper',
            'headline' => 'News from <span class="text-gradient">Impact Waves</span>',
            'lead' => 'Agency updates, new partnerships and what is changing in paid social, search and feed monetization.',
            'meta_title' => 'News: Impact Waves Agency Updates',
            'meta_description' => 'Latest news from Impact Waves Agency: new services, partnerships and updates on paid social, TikTok ads and search feed monetization.',
        ],
    ],

    'values' => [
        ['icon' => 'chart', 'title' => 'Data-driven', 'text' => 'Every decision starts with numbers: tracking first, opinions second.'],
        ['icon' => 'chat', 'title' => 'Communication', 'text' => 'Direct access to the people running your campaigns, not an account-manager relay.'],
        ['icon' => 'eye', 'title' => 'Transparency', 'text' => 'You see what we spend, what we test and what we learn. No black boxes.'],
        ['icon' => 'compass', 'title' => 'Strategy', 'text' => 'Campaigns built around your growth requirements, not a template.'],
        ['icon' => 'lifebuoy', 'title' => 'Comprehensive support', 'text' => 'Tutorials, technical assistance and personalized assessments whenever you need them.'],
        ['icon' => 'globe', 'title' => 'Key markets', 'text' => 'Hands-on experience reaching audiences in the US, EU and Canada.'],
    ],

    'process' => [
        ['title' => 'Audit', 'text' => 'We review your accounts, tracking, funnel and unit economics to find the fastest wins.'],
        ['title' => 'Strategy', 'text' => 'A channel, creative and budget plan built around your most critical growth requirements.'],
        ['title' => 'Launch', 'text' => 'Campaigns go live with clean tracking and a structured testing roadmap.'],
        ['title' => 'Scale', 'text' => 'Daily optimization, transparent reporting and budget moved to what works.'],
    ],

    'faq' => [
        ['q' => 'Which markets do you work with?', 'a' => 'We focus on the United States, the European Union and Canada, and run campaigns in each of these markets.'],
        ['q' => 'Are you an official TikTok agency?', 'a' => 'Yes. We work as an official TikTok agency, which gives our clients agency ad accounts and support from a dedicated TikTok team.'],
        ['q' => 'Do you work with media buyers and arbitrage teams?', 'a' => 'Yes. Alongside brand work, we partner with Tier-1 search feed providers such as Bodis, Tonic, Ads.com and DomainActive and help teams build compliant monetization setups.'],
        ['q' => 'What budget do I need to start?', 'a' => 'It depends on your channel mix and goals. Tell us your monthly budget in the form below and we will recommend a setup that makes sense for it.'],
        ['q' => 'How do you report on results?', 'a' => 'You get transparent reporting on spend, tests and outcomes, plus direct communication with the team working on your account.'],
    ],

    'budgets' => [
        'under-10k' => 'Under $10k / month',
        '10k-50k' => '$10k to $50k / month',
        '50k-200k' => '$50k to $200k / month',
        '200k-plus' => '$200k+ / month',
    ],

];
