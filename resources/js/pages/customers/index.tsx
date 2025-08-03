import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface Customer {
    id: number;
    name: string;
    email: string;
    phone: string | null;
    address: string | null;
    status: string;
    mikrotik_username: string | null;
    package: string | null;
    created_at: string;
}

interface Props {
    customers: {
        data: Customer[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Customers', href: '/customers' },
];

export default function CustomersIndex({ customers }: Props) {
    const getStatusBadge = (status: string) => {
        switch (status) {
            case 'active':
                return <Badge className="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✅ Active</Badge>;
            case 'inactive':
                return <Badge variant="secondary">⏸️ Inactive</Badge>;
            case 'suspended':
                return <Badge variant="destructive">⚠️ Suspended</Badge>;
            default:
                return <Badge variant="outline">{status}</Badge>;
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Customer Management" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold">👥 Customer Management</h1>
                        <p className="text-muted-foreground mt-2">
                            Manage customer information and MikroTik billing integration
                        </p>
                    </div>
                    <Button asChild>
                        <Link href="/customers/create">➕ Add Customer</Link>
                    </Button>
                </div>

                {/* Stats Cards */}
                <div className="grid gap-4 md:grid-cols-3">
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-2xl font-bold text-blue-600">
                                {customers.total}
                            </CardTitle>
                            <CardDescription>Total Customers</CardDescription>
                        </CardHeader>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-2xl font-bold text-green-600">
                                {customers.data.filter(c => c.status === 'active').length}
                            </CardTitle>
                            <CardDescription>Active Customers</CardDescription>
                        </CardHeader>
                    </Card>
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-2xl font-bold text-orange-600">
                                {customers.data.filter(c => c.mikrotik_username).length}
                            </CardTitle>
                            <CardDescription>MikroTik Integrated</CardDescription>
                        </CardHeader>
                    </Card>
                </div>

                {/* Customers List */}
                <Card>
                    <CardHeader>
                        <CardTitle>Customer List</CardTitle>
                        <CardDescription>
                            Showing {customers.data.length} of {customers.total} customers
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            {customers.data.map((customer) => (
                                <div key={customer.id} className="flex items-center justify-between p-4 border rounded-lg">
                                    <div className="flex-1">
                                        <div className="flex items-center gap-4">
                                            <div>
                                                <h3 className="font-semibold">{customer.name}</h3>
                                                <p className="text-sm text-muted-foreground">{customer.email}</p>
                                                {customer.phone && (
                                                    <p className="text-sm text-muted-foreground">📞 {customer.phone}</p>
                                                )}
                                            </div>
                                            <div className="ml-8">
                                                {customer.package && (
                                                    <p className="text-sm font-medium">📦 {customer.package}</p>
                                                )}
                                                {customer.mikrotik_username && (
                                                    <p className="text-sm text-muted-foreground">🔗 {customer.mikrotik_username}</p>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        {getStatusBadge(customer.status)}
                                        <Button asChild variant="outline" size="sm">
                                            <Link href={`/customers/${customer.id}`}>View</Link>
                                        </Button>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {customers.data.length === 0 && (
                            <div className="text-center py-8">
                                <p className="text-muted-foreground">No customers found.</p>
                                <Button asChild className="mt-4">
                                    <Link href="/customers/create">Add Your First Customer</Link>
                                </Button>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}