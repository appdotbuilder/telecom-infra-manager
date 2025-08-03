import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface Region {
    id: number;
    name: string;
    code: string;
    description: string | null;
    stage: string;
    data_completed: boolean;
    design_completed: boolean;
    rab_completed: boolean;
    permits_completed: boolean;
    created_at: string;
}

interface Props {
    regions: {
        data: Region[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Regions', href: '/regions' },
];

export default function RegionsIndex({ regions }: Props) {
    const getStageBadge = (stage: string) => {
        switch (stage) {
            case 'completed':
                return <Badge className="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✅ Completed</Badge>;
            case 'permits':
                return <Badge className="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">📋 Permits</Badge>;
            case 'rab':
                return <Badge className="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">💰 RAB</Badge>;
            case 'design':
                return <Badge className="bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">🎨 Design</Badge>;
            case 'data':
                return <Badge variant="outline">📊 Data</Badge>;
            default:
                return <Badge variant="outline">{stage}</Badge>;
        }
    };

    const getStageProgress = (region: Region) => {
        const stages = [
            { name: 'Data', completed: region.data_completed },
            { name: 'Design', completed: region.design_completed },
            { name: 'RAB', completed: region.rab_completed },
            { name: 'Permits', completed: region.permits_completed },
        ];
        
        const completedStages = stages.filter(s => s.completed).length;
        return `${completedStages}/4`;
    };

    const stageOrder = ['data', 'design', 'rab', 'permits', 'completed'];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Region Management" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold">🗺️ Region Management</h1>
                        <p className="text-muted-foreground mt-2">
                            Multi-stage region development: Data → Design → RAB → Permits → Completion
                        </p>
                    </div>
                    <Button asChild>
                        <Link href="/regions/create">➕ Add Region</Link>
                    </Button>
                </div>

                {/* Stats Cards */}
                <div className="grid gap-4 md:grid-cols-5">
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-2xl font-bold text-blue-600">
                                {regions.total}
                            </CardTitle>
                            <CardDescription>Total Regions</CardDescription>
                        </CardHeader>
                    </Card>
                    {stageOrder.map((stage) => (
                        <Card key={stage}>
                            <CardHeader className="pb-2">
                                <CardTitle className="text-2xl font-bold text-purple-600">
                                    {regions.data.filter(r => r.stage === stage).length}
                                </CardTitle>
                                <CardDescription className="capitalize">{stage === 'rab' ? 'RAB' : stage}</CardDescription>
                            </CardHeader>
                        </Card>
                    ))}
                </div>

                {/* Stage Pipeline */}
                <Card>
                    <CardHeader>
                        <CardTitle>🔄 Development Pipeline</CardTitle>
                        <CardDescription>Track regions through the development stages</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="flex items-center justify-between p-4 bg-muted/50 rounded-lg">
                            {[
                                { stage: 'data', icon: '📊', label: 'Data Collection' },
                                { stage: 'design', icon: '🎨', label: 'Design Phase' },
                                { stage: 'rab', icon: '💰', label: 'Budget Planning' },
                                { stage: 'permits', icon: '📋', label: 'Permits' },
                                { stage: 'completed', icon: '✅', label: 'Completed' },
                            ].map((item, index) => (
                                <div key={item.stage} className="flex flex-col items-center">
                                    <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-xl mb-2">
                                        {item.icon}
                                    </div>
                                    <p className="text-sm font-medium text-center">{item.label}</p>
                                    <p className="text-xs text-muted-foreground">
                                        {regions.data.filter(r => r.stage === item.stage).length} regions
                                    </p>
                                    {index < 4 && (
                                        <div className="absolute w-8 h-0.5 bg-border translate-x-8 translate-y-6" />
                                    )}
                                </div>
                            ))}
                        </div>
                    </CardContent>
                </Card>

                {/* Regions List */}
                <Card>
                    <CardHeader>
                        <CardTitle>Region Portfolio</CardTitle>
                        <CardDescription>
                            Showing {regions.data.length} of {regions.total} regions
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            {regions.data.map((region) => (
                                <div key={region.id} className="flex items-center justify-between p-4 border rounded-lg">
                                    <div className="flex-1">
                                        <div className="flex items-center gap-4">
                                            <div>
                                                <h3 className="font-semibold">{region.name}</h3>
                                                <p className="text-sm text-muted-foreground font-mono">{region.code}</p>
                                                {region.description && (
                                                    <p className="text-sm text-muted-foreground mt-1">{region.description}</p>
                                                )}
                                            </div>
                                            <div className="ml-8">
                                                <p className="text-sm font-medium">
                                                    📈 Progress: {getStageProgress(region)} stages
                                                </p>
                                                <div className="flex gap-1 mt-1">
                                                    <div className={`w-3 h-3 rounded-full ${region.data_completed ? 'bg-green-500' : 'bg-gray-300'}`} />
                                                    <div className={`w-3 h-3 rounded-full ${region.design_completed ? 'bg-green-500' : 'bg-gray-300'}`} />
                                                    <div className={`w-3 h-3 rounded-full ${region.rab_completed ? 'bg-green-500' : 'bg-gray-300'}`} />
                                                    <div className={`w-3 h-3 rounded-full ${region.permits_completed ? 'bg-green-500' : 'bg-gray-300'}`} />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        {getStageBadge(region.stage)}
                                        <Button asChild variant="outline" size="sm">
                                            <Link href={`/regions/${region.id}`}>View</Link>
                                        </Button>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {regions.data.length === 0 && (
                            <div className="text-center py-8">
                                <p className="text-muted-foreground">No regions found.</p>
                                <Button asChild className="mt-4">
                                    <Link href="/regions/create">Create Your First Region</Link>
                                </Button>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}