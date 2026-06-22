import SiteLayout from '@/Layouts/SiteLayout';
import ProjectCard from '@/Components/ProjectCard';
import PageMark from '@/Components/PageMark';

export default function PortfolioIndex({ projects }) {
    return (
        <SiteLayout title="Release Index">
            <PageMark code="IDX" label="Release Index" />

            <div className="py-20 sm:py-28 bg-paper dark:bg-night min-h-screen">
                <div className="max-w-5xl mx-auto px-6 lg:px-0 lg:ml-40 lg:pr-12">
                    <div className="max-w-xl border-b border-line dark:border-line-dark pb-8 mb-12">
                        <p className="font-mono text-[10px] tracking-[0.25em] text-slate dark:text-slate-dark uppercase mb-3">
                            ALL RELEASES
                        </p>
                        <h1 className="font-sans font-black text-3xl md:text-4xl tracking-tight text-ink dark:text-paper-dark uppercase mb-3">
                            Release index
                        </h1>
                        <p className="text-sm text-slate dark:text-slate-dark leading-relaxed">
                            Every shipped project, from full-stack builds to interface explorations.
                        </p>
                    </div>

                    {projects && projects.length > 0 ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
                            {projects.map((project, idx) => (
                                <ProjectCard key={project.id ?? idx} project={project} index={idx} />
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-20 border border-dashed border-line dark:border-line-dark">
                            <p className="font-mono text-xs text-slate dark:text-slate-dark">
                                no releases tagged yet — check back soon.
                            </p>
                        </div>
                    )}
                </div>
            </div>
        </SiteLayout>
    );
}