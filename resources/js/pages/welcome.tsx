import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    const features = [
        {
            icon: '👥',
            title: 'Customer & Billing Management',
            description: 'Manage customer information, billing records, and MikroTik integration for usage tracking',
            color: 'bg-blue-50 dark:bg-blue-950/20'
        },
        {
            icon: '📡',
            title: 'Network Device Management',
            description: 'Control ODC, ODP, closures, and other network equipment with integrated mapping',
            color: 'bg-green-50 dark:bg-green-950/20'
        },
        {
            icon: '🗺️',
            title: 'Region Management',
            description: 'Multi-stage region setup: Data → Design → RAB → Permits → Completion',
            color: 'bg-purple-50 dark:bg-purple-950/20'
        },
        {
            icon: '👨‍💼',
            title: 'User Management',
            description: 'Comprehensive user administration with roles and permissions',
            color: 'bg-orange-50 dark:bg-orange-950/20'
        }
    ];

    const stats = [
        { label: 'Network Coverage', value: '50+ Areas', icon: '📶' },
        { label: 'Active Customers', value: '1,200+', icon: '👥' },
        { label: 'Network Devices', value: '300+', icon: '📡' },
        { label: 'Completed Regions', value: '25+', icon: '✅' }
    ];

    return (
        <>
            <Head title="Telecom Infrastructure Management">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-blue-950/20 dark:via-gray-900 dark:to-purple-950/20">
                {/* Header */}
                <header className="sticky top-0 z-50 border-b bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 dark:border-gray-800">
                    <div className="mx-auto max-w-7xl px-6 py-4">
                        <nav className="flex items-center justify-between">
                            <div className="flex items-center gap-2 text-xl font-bold">
                                <span className="text-2xl">📡</span>
                                <span className="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    TelecomManager
                                </span>
                            </div>
                            <div className="flex items-center gap-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
                                    >
                                        🚀 Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-800"
                                        >
                                            🔐 Login
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
                                        >
                                            📝 Register
                                        </Link>
                                    </>
                                )}
                            </div>
                        </nav>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="px-6 py-20">
                    <div className="mx-auto max-w-6xl text-center">
                        <div className="mb-6">
                            <div className="mb-4 inline-flex items-center rounded-full bg-primary/10 px-4 py-2 text-sm font-medium text-primary">
                                🚀 Professional Telecom Management
                            </div>
                            <h1 className="mb-6 text-5xl font-bold tracking-tight lg:text-6xl">
                                <span className="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    📡 Telecom Infrastructure
                                </span>
                                <br />
                                <span className="text-gray-900 dark:text-white">Management System</span>
                            </h1>
                            <p className="mx-auto max-w-3xl text-xl text-gray-600 dark:text-gray-300 leading-relaxed">
                                Complete solution for managing telecommunications infrastructure, customer billing with MikroTik integration, 
                                network device monitoring, and multi-stage region development planning.
                            </p>
                        </div>

                        {/* Stats Grid */}
                        <div className="mb-12 grid grid-cols-2 gap-4 md:grid-cols-4">
                            {stats.map((stat, index) => (
                                <div key={index} className="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                                    <div className="text-3xl mb-2">{stat.icon}</div>
                                    <div className="text-2xl font-bold text-primary">{stat.value}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">{stat.label}</div>
                                </div>
                            ))}
                        </div>

                        {/* CTA Buttons */}
                        <div className="flex flex-col gap-4 sm:flex-row sm:justify-center">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="inline-flex items-center justify-center rounded-lg bg-primary px-8 py-4 text-lg font-medium text-primary-foreground hover:bg-primary/90"
                                >
                                    🚀 Go to Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('register')}
                                        className="inline-flex items-center justify-center rounded-lg bg-primary px-8 py-4 text-lg font-medium text-primary-foreground hover:bg-primary/90"
                                    >
                                        🚀 Get Started
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="inline-flex items-center justify-center rounded-lg border border-gray-300 px-8 py-4 text-lg font-medium hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-800"
                                    >
                                        🔐 Login
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </section>

                {/* Features Section */}
                <section className="px-6 py-20 bg-white/60 dark:bg-gray-900/60">
                    <div className="mx-auto max-w-6xl">
                        <div className="mb-16 text-center">
                            <h2 className="mb-4 text-4xl font-bold">🎯 Comprehensive Features</h2>
                            <p className="text-xl text-gray-600 dark:text-gray-300">
                                Everything you need to manage your telecommunications infrastructure efficiently
                            </p>
                        </div>

                        <div className="grid gap-8 md:grid-cols-2">
                            {features.map((feature, index) => (
                                <div key={index} className={`${feature.color} rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow`}>
                                    <div className="flex items-start gap-4">
                                        <div className="text-4xl">{feature.icon}</div>
                                        <div>
                                            <h3 className="mb-3 text-xl font-semibold">{feature.title}</h3>
                                            <p className="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                {feature.description}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Integration Section */}
                <section className="px-6 py-20">
                    <div className="mx-auto max-w-4xl text-center">
                        <div className="rounded-xl border-2 border-dashed border-primary/20 bg-primary/5 p-12">
                            <h2 className="mb-4 text-3xl font-bold">🔗 MikroTik Integration</h2>
                            <p className="mb-8 text-xl text-gray-600 dark:text-gray-300">
                                Seamlessly sync customer usage data and manage network accounts
                            </p>
                            <div className="grid gap-6 md:grid-cols-3">
                                <div className="text-center">
                                    <div className="text-3xl mb-3">📊</div>
                                    <div className="font-semibold mb-1">Usage Tracking</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">Real-time data sync</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-3xl mb-3">💳</div>
                                    <div className="font-semibold mb-1">Automated Billing</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">Usage-based invoicing</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-3xl mb-3">🎛️</div>
                                    <div className="font-semibold mb-1">Account Management</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">Remote control</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Footer */}
                <footer className="px-6 py-12 bg-gray-50 dark:bg-gray-900 border-t dark:border-gray-800">
                    <div className="mx-auto max-w-4xl text-center">
                        <p className="text-gray-600 dark:text-gray-400 mb-2">
                            🏢 Professional telecommunications infrastructure management solution
                        </p>
                        <p className="text-sm text-gray-500 dark:text-gray-500">
                            Ready to deploy • Scalable • Feature-complete
                        </p>
                        <div className="mt-8 text-sm text-gray-500 dark:text-gray-500">
                            Built with ❤️ by{" "}
                            <a 
                                href="https://app.build" 
                                target="_blank" 
                                className="font-medium text-primary hover:underline"
                            >
                                app.build
                            </a>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}