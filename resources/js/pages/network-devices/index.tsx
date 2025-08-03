import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface NetworkDevice {
    id: number;
    name: string;
    type: string;
    latitude: number;
    longitude: number;
    address: string | null;
    status: string;
    port_count: number | null;
    ports_used: number;
    notes: string | null;
    created_at: string;
}

interface Props {
    devices: {
        data: NetworkDevice[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Network Devices', href: '/network-devices' },
];

export default function NetworkDevicesIndex({ devices }: Props) {
    const getStatusBadge = (status: string) => {
        switch (status) {
            case 'active':
                return <Badge className="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✅ Active</Badge>;
            case 'inactive':
                return <Badge variant="secondary">⏸️ Inactive</Badge>;
            case 'maintenance':
                return <Badge variant="outline">🔧 Maintenance</Badge>;
            default:
                return <Badge variant="outline">{status}</Badge>;
        }
    };

    const getTypeIcon = (type: string) => {
        switch (type) {
            case 'ODC':
                return '🏢';
            case 'ODP':
                return '📦';
            case 'closure':
                return '🔗';
            case 'router':
                return '📡';
            case 'switch':
                return '🔌';
            default:
                return '⚙️';
        }
    };

    const getPortUtilization = (used: number, total: number | null) => {
        if (!total) return 'N/A';
        const percentage = (used / total) * 100;
        return `${used}/${total} (${percentage.toFixed(1)}%)`;
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Network Device Management" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold">📡 Network Device Management</h1>
                        <p className="text-muted-foreground mt-2">
                            Monitor and manage ODC, ODP, closures, and network equipment
                        </p>
                    </div>
                    <Button asChild>
                        <Link href="/network-devices/create">➕ Add Device</Link>
                    </Button>
                </div>

                {/* Stats Cards */}
                <div className="grid gap-4 md:grid-cols-4">
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-2xl font-bold text-blue-600">
                                {devices.total}
                            </CardTitle>
                            <CardDescription>Total Devices</CardDescription>
                        </CardHeader>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-2xl font-bold text-green-600">
                                {devices.data.filter(d => d.status === 'active').length}
                            </CardTitle>
                            <CardDescription>Active Devices</CardDescription>
                        </CardHeader>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-2xl font-bold text-orange-600">
                                {devices.data.filter(d => d.status === 'maintenance').length}
                            </CardTitle>
                            <CardDescription>Under Maintenance</CardDescription>
                        </CardHeader>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-2xl font-bold text-purple-600">
                                {devices.data.reduce((sum, d) => sum + d.ports_used, 0)}
                            </CardTitle>
                            <CardDescription>Total Ports Used</CardDescription>
                        </CardHeader>
                    </Card>
                </div>

                {/* Device Types Filter */}
                <div className="flex gap-2 flex-wrap">
                    {['All', 'ODC', 'ODP', 'closure', 'router', 'switch'].map((type) => (
                        <Button key={type} variant="outline" size="sm">
                            {type === 'All' ? '📋' : getTypeIcon(type)} {type}
                        </Button>
                    ))}
                </div>

                {/* Devices List */}
                <Card>
                    <CardHeader>
                        <CardTitle>Device Inventory</CardTitle>
                        <CardDescription>
                            Showing {devices.data.length} of {devices.total} devices
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            {devices.data.map((device) => (
                                <div key={device.id} className="flex items-center justify-between p-4 border rounded-lg">
                                    <div className="flex-1">
                                        <div className="flex items-center gap-4">
                                            <div className="text-2xl">{getTypeIcon(device.type)}</div>
                                            <div>
                                                <h3 className="font-semibold">{device.name}</h3>
                                                <p className="text-sm text-muted-foreground uppercase font-medium">{device.type}</p>
                                                {device.address && (
                                                    <p className="text-sm text-muted-foreground">📍 {device.address}</p>
                                                )}
                                            </div>
                                            <div className="ml-8">
                                                <p className="text-sm font-medium">
                                                    🌍 {device.latitude.toFixed(6)}, {device.longitude.toFixed(6)}
                                                </p>
                                                {device.port_count && (
                                                    <p className="text-sm text-muted-foreground">
                                                        🔌 Ports: {getPortUtilization(device.ports_used, device.port_count)}
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        {getStatusBadge(device.status)}
                                        <Button asChild variant="outline" size="sm">
                                            <Link href={`/network-devices/${device.id}`}>View</Link>
                                        </Button>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {devices.data.length === 0 && (
                            <div className="text-center py-8">
                                <p className="text-muted-foreground">No network devices found.</p>
                                <Button asChild className="mt-4">
                                    <Link href="/network-devices/create">Add Your First Device</Link>
                                </Button>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}