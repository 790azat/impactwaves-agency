<?php

return [

    'name' => 'Impact Waves',
    'legal_name' => 'Impact Waves Agency',
    'tagline' => "Swift and effective solutions for your company's growth.",
    'description' => 'Performance marketing agency: paid social, PPC, CRO, official TikTok agency accounts and Tier-1 search feed partnerships for the US, EU and Canada.',

    // Where contact-form leads are delivered. Override with AGENCY_EMAIL on Vercel.
    'email' => env('AGENCY_EMAIL', 'hello@impactwaves.agency'),
    'linkedin' => 'https://www.linkedin.com/company/impact-waves-agency/',

    'markets' => [
        ['code' => 'US', 'name' => 'United States'],
        ['code' => 'EU', 'name' => 'European Union'],
        ['code' => 'CA', 'name' => 'Canada'],
    ],

    'partners' => ['Bodis', 'Tonic', 'Ads.com', 'DomainActive', 'TikTok for Business', 'Meta', 'Google Ads', 'Microsoft Advertising'],

    'feed_partners' => ['Bodis', 'Tonic', 'Ads.com', 'DomainActive'],

    'platforms' => ['TikTok', 'Meta', 'Google', 'Microsoft', 'Snapchat', 'Pinterest', 'Native'],

    'services' => [
        'paid-social' => [
            'title' => 'Paid Social Ads',
            'eyebrow' => 'Social',
            'icon' => 'megaphone',
            'short' => 'Engage your most passionate fans and build fresh connections across every social feed.',
            'headline' => 'Engage your most passionate fans and build fresh connections.',
            'intro' => 'We plan, launch and scale social campaigns that turn scrolling into revenue. Every campaign is built on clean tracking, disciplined creative testing and daily optimization, so budget flows to what actually converts.',
            'platforms' => ['Meta', 'TikTok', 'Snapchat', 'Pinterest', 'X'],
            'features' => [
                ['title' => 'Full-funnel architecture', 'text' => 'Prospecting, retargeting and retention campaigns that work together instead of competing for the same users.'],
                ['title' => 'Audience research', 'text' => 'Interest, behavioral and lookalike modeling built from your first-party data and market insight.'],
                ['title' => 'Creative testing framework', 'text' => 'Structured hook, angle and format tests that find winners fast and retire fatigue before it costs you.'],
                ['title' => 'Pixel, CAPI and server-side tracking', 'text' => 'Reliable signal for the algorithms, and reporting you can trust.'],
                ['title' => 'Daily optimization and scaling', 'text' => 'Budget, bid and structure decisions made on data every day, not once a month.'],
            ],
        ],
        'ppc' => [
            'title' => 'PPC Advertising',
            'eyebrow' => 'Search',
            'icon' => 'cursor',
            'short' => 'Maximize your earnings quickly and effectively with search and pay-per-click strategies.',
            'headline' => 'Maximize your earnings quickly and effectively with PPC.',
            'intro' => 'Capture demand at the exact moment people are looking for you. We build search and shopping campaigns around intent, margin and lifetime value, then keep them sharp with continuous testing.',
            'platforms' => ['Google Ads', 'Microsoft Ads', 'Native'],
            'features' => [
                ['title' => 'Keyword and intent mapping', 'text' => 'Campaign structure that mirrors how your buyers actually search.'],
                ['title' => 'Bid strategy management', 'text' => 'Smart bidding guided by profit targets, not vanity metrics.'],
                ['title' => 'Shopping and feed campaigns', 'text' => 'Product feed optimization that improves relevance and click share.'],
                ['title' => 'Query hygiene', 'text' => 'Relentless negative keyword work to stop paying for clicks that never convert.'],
                ['title' => 'Cross-channel attribution', 'text' => 'A clear view of how search works alongside social and your other channels.'],
            ],
        ],
        'cro' => [
            'title' => 'Conversion Rate Optimization',
            'eyebrow' => 'CRO',
            'icon' => 'chart',
            'short' => 'Increase leads, grow your customer base and lift retention with data-driven optimization.',
            'headline' => 'Turn more of your traffic into leads, customers and repeat buyers.',
            'intro' => 'Buying traffic is only half the equation. We find the leaks in your funnel and fix them with research-backed experiments, so every dollar of ad spend works harder.',
            'platforms' => ['GA4', 'Heatmaps', 'A/B testing', 'Landing pages'],
            'features' => [
                ['title' => 'Funnel analytics', 'text' => 'Heatmaps, session recordings and funnel reports that show where users drop off and why.'],
                ['title' => 'A/B and multivariate testing', 'text' => 'Hypothesis-driven experiments with proper sample sizes and clear decisions.'],
                ['title' => 'Landing page design and build', 'text' => 'Fast, focused pages designed for the traffic source that feeds them.'],
                ['title' => 'Offer and pricing experiments', 'text' => 'Test bundles, guarantees and pricing presentation to lift average order value.'],
                ['title' => 'Retention flows', 'text' => 'Onboarding, win-back and repeat-purchase journeys that raise customer lifetime value.'],
            ],
        ],
        'tiktok-agency' => [
            'title' => 'TikTok Agency Accounts',
            'eyebrow' => 'Official TikTok agency',
            'icon' => 'bolt',
            'short' => 'Attract audiences and drive revenue with official TikTok agency accounts and a dedicated support team.',
            'headline' => 'Scale on TikTok with an official agency behind you.',
            'intro' => 'As an official TikTok agency, we give advertisers access to agency ad accounts, direct support from a dedicated TikTok team and the creative resources needed to grow on the fastest-moving platform in advertising.',
            'platforms' => ['TikTok Ads Manager', 'Spark Ads', 'TikTok Shop'],
            'features' => [
                ['title' => 'Agency ad accounts', 'text' => 'Access to agency-level ad accounts for the US, EU and Canadian markets.'],
                ['title' => 'Dedicated TikTok team support', 'text' => 'Official support channels for faster answers on reviews, policies and account questions.'],
                ['title' => 'Tailored growth strategies', 'text' => 'Campaign and creative strategies built around your product, audience and goals.'],
                ['title' => 'Personalized assessments', 'text' => 'Account audits and recommendations to improve delivery, costs and conversion.'],
                ['title' => 'Creative resources', 'text' => 'Learning center, ad library and tutorials to keep your creative ahead of the feed.'],
            ],
        ],
        'search-feeds' => [
            'title' => 'Search Feed Monetization',
            'eyebrow' => 'Tier-1 feeds',
            'icon' => 'layers',
            'short' => 'Monetize traffic through Tier-1 search feed partners including Bodis, Tonic, Ads.com and DomainActive.',
            'headline' => 'Tier-1 feed partnerships to monetize your traffic.',
            'intro' => 'We connect media buyers and publishers with Tier-1 search feed providers and help them run compliant, profitable monetization setups, from onboarding to reporting.',
            'platforms' => ['Bodis', 'Tonic', 'Ads.com', 'DomainActive'],
            'features' => [
                ['title' => 'Tier-1 feed access', 'text' => 'Onboarding with established feed providers instead of long waitlists.'],
                ['title' => 'Compliant setups', 'text' => 'Guidance on content, traffic sources and policies that keep accounts healthy.'],
                ['title' => 'Traffic quality monitoring', 'text' => 'Early signals on quality issues before they affect your revenue share.'],
                ['title' => 'Revenue reporting', 'text' => 'Consolidated reporting across feeds and traffic sources to find the best margins.'],
                ['title' => 'Media buying synergy', 'text' => 'Paid social and PPC expertise applied to the traffic side of the equation.'],
            ],
        ],
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
