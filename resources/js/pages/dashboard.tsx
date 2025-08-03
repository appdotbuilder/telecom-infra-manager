import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface Props {
    stats: {
        customers: number;
        active_customers: number;
        network_devices: number;
        active_devices: number;
        regions: number;
        completed_regions: number;
        pending_bills: number;
        overdue_bills: number;
    };
    recent_customers: Array<{
        id: number;
        name: string;
        email: string;
        status: string;
        created_at: string;
    }>;
    recent_devices: Array<{
        id: number;
        name: string;
        type: string;
        status: string;
        created_at: string;
    }>;
    recent_regions: Array<{
        id: number;
        name: string;
        code: string;
        stage: string;
        created_at: string;
    }>;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ stats, recent_customers, recent_devices, recent_regions }: Props) {
    const quickStats = [
        {
            title: '👥 Total Customers',
            value: stats.customers.toLocaleString(),
            subtitle: `${stats.active_customers} active`,
            color: 'text-blue-600',
        },
        {
            title: '📡 Network Devices',
            value: stats.network_devices.toLocaleString(),
            subtitle: `${stats.active_devices} active`,
            color: 'text-green-600',
        },
        {
            title: '🗺️ Regions',
            value: stats.regions.toLocaleString(),
            subtitle: `${stats.completed_regions} completed`,
            color: 'text-purple-600',
        },
        {
            title: '💳 Billing',
            value: stats.pending_bills.toLocaleString(),
            subtitle: `${stats.overdue_bills} overdue`,
            color: 'text-orange-600',
        },
    ];

    const modules = [
        {
            title: 'Customer Management',
            description: 'Manage customers and billing with MikroTik integration',
            icon: '👥',
            href: '/customers',
            color: 'bg-blue-50 hover:bg-blue-100 border-blue-200 dark:bg-blue-950/20 dark:hover:bg-blue-950/30',
        },
        {
            title: 'Network Devices',
            description: 'Monitor and manage ODC, ODP, closures, and equipment',
            icon: '📡',
            href: '/network-devices',
            color: 'bg-green-50 hover:bg-green-100 border-green-200 dark:bg-green-950/20 dark:hover:bg-green-950/30',
        },
        {
            title: 'Region Planning',
            description: 'Multi-stage region development workflow',
            icon: '🗺️',
            href: '/regions',
            color: 'bg-purple-50 hover:bg-purple-100 border-purple-200 dark:bg-purple-950/20 dark:hover:bg-purple-950/30',
        },
    ];

    const getStatusBadge = (status: string) => {
        switch (status) {
            case 'active':
                return <Badge variant="default" className="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✅ Active</Badge>;
            case 'inactive':
                return <Badge variant="secondary">⏸️ Inactive</Badge>;
            case 'suspended':
                return <Badge variant="destructive">⚠️ Suspended</Badge>;
            case 'maintenance':
                return <Badge variant="outline">🔧 Maintenance</Badge>;
            case 'completed':
                return <Badge variant="default" className="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✅ Completed</Badge>;
            case 'permits':
                return <Badge variant="default" className="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">📋 Permits</Badge>;
            case 'rab':
                return <Badge variant="default" className="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">💰 RAB</Badge>;
            case 'design':
                return <Badge variant="default" className="bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">🎨 Design</Badge>;
            case 'data':
                return <Badge variant="outline">📊 Data</Badge>;
            default:
                return <Badge variant="outline">{status}</Badge>;
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Telecom Infrastructure Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
                <div>
                    <h1 className="text-3xl font-bold">📊 Telecom Infrastructure Dashboard</h1>
                    <p className="text-muted-foreground mt-2">
                        Monitor and manage your telecommunications infrastructure from a single dashboard
                    </p>
                </div>

                {/* Quick Stats */}
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    {quickStats.map((stat, index) => (
                        <Card key={index}>
                            <CardHeader className="pb-2">
                                <CardTitle className={`text-2xl font-bold ${stat.color}`}>
                                    {stat.value}
                                </CardTitle>
                                <CardDescription className="font-medium">
                                    {stat.title}
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <p className="text-sm text-muted-foreground">{stat.subtitle}</p>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                {/* Quick Access Modules */}
                <div>
                    <h2 className="text-xl font-semibold mb-4">🚀 Quick Access</h2>
                    <div className="grid gap-6 md:grid-cols-3">
                        {modules.map((module, index) => (
                            <Card key={index} className={`${module.color} transition-colors cursor-pointer`}>
                                <CardHeader>
                                    <div className="flex items-center gap-3">
                                        <div className="text-2xl">{module.icon}</div>
                                        <div>
                                            <CardTitle className="text-lg">{module.title}</CardTitle>
                                            <CardDescription>{module.description}</CardDescription>
                                        </div>
                                    </div>
                                </CardHeader>
                                <CardContent>
                                    <Button asChild className="w-full">
                                        <Link href={module.href}>Manage</Link>
                                    </Button>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                </div>

                {/* Recent Activity */}
                <div className="grid gap-6 lg:grid-cols-3">
                    {/* Recent Customers */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                👥 Recent Customers
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {recent_customers.map((customer) => (
                                <div key={customer.id} className="flex items-center justify-between p-2 rounded border">
                                    <div>
                                        <p className="font-medium text-sm">{customer.name}</p>
                                        <p className="text-xs text-muted-foreground">{customer.email}</p>
                                    </div>
                                    {getStatusBadge(customer.status)}
                                </div>
                            ))}
                            <Button asChild variant="outline" className="w-full mt-4">
                                <Link href="/customers">View All</Link>
                            </Button>
                        </CardContent>
                    </Card>

                    {/* Recent Devices */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                📡 Recent Devices
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {recent_devices.map((device) => (
                                <div key={device.id} className="flex items-center justify-between p-2 rounded border">
                                    <div>
                                        <p className="font-medium text-sm">{device.name}</p>
                                        <p className="text-xs text-muted-foreground">{device.type}</p>
                                    </div>
                                    {getStatusBadge(device.status)}
                                </div>
                            ))}
                            <Button asChild variant="outline" className="w-full mt-4">
                                <Link href="/network-devices">View All</Link>
                            </Button>
                        </CardContent>
                    </Card>

                    {/* Recent Regions */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                🗺️ Recent Regions
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {recent_regions.map((region) => (
                                <div key={region.id} className="flex items-center justify-between p-2 rounded border">
                                    <div>
                                        <p className="font-medium text-sm">{region.name}</p>
                                        <p className="text-xs text-muted-foreground">{region.code}</p>
                                    </div>
                                    {getStatusBadge(region.stage)}
                                </div>
                            ))}
                            <Button asChild variant="outline" className="w-full mt-4">
                                <Link href="/regions">View All</Link>
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}