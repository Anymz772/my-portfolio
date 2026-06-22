import { motion } from 'framer-motion';
import { useState } from 'react';
import ProjectCard from './ProjectCard';

export default function Projects({ projects, title = 'Projects' }) {
    const [filter, setFilter] = useState('All');

    if (!projects || projects.length === 0) return null;

    // Collect unique tech tags for filter buttons
    const allTags = ['All', ...Array.from(
        new Set(
            projects.flatMap((p) =>
                p.tech_stack ? p.tech_stack.split(',').map((t) => t.trim()) : []
            )
        )
    ).slice(0, 6)]; // cap at 6 tags to keep the filter row tidy

    const filtered = filter === 'All'
        ? projects
        : projects.filter((p) => p.tech_stack?.includes(filter));

    return (
        <section id="releases" className="py-24 bg-paper dark:bg-night border-t border-line dark:border-line-dark">
            <div className="max-w-5xl mx-auto px-6 lg:px-0 lg:ml-40 lg:pr-12">
                {/* Section header */}
                <motion.div
                    initial={{ opacity: 0, y: 16 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.5 }}
                    viewport={{ once: true }}
                    className="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-16"
                >
                    <div>
                        <p className="font-mono text-[10px] tracking-[0.25em] text-slate dark:text-slate-dark uppercase mb-3">
                            02 PORTFOLIO
                        </p>
                        <h2 className="font-sans font-black text-3xl md:text-4xl tracking-tight text-ink dark:text-paper-dark uppercase">
                            My latest work
                        </h2>
                    </div>

                    {/* All releases link */}
                    <div className="flex items-center">
                        <a
                            href="/portfolio"
                            className="font-mono text-[10px] uppercase tracking-widest text-ink dark:text-paper-dark border-b border-ink dark:border-paper-dark pb-0.5 hover:text-slate dark:hover:text-slate-dark hover:border-slate dark:hover:border-slate-dark transition-colors font-bold"
                        >
                            See all releases &gt;
                        </a>
                    </div>
                </motion.div>

                {/* Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {filtered.map((project, index) => (
                        <motion.div
                            key={project.id}
                            initial={{ opacity: 0, y: 24 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.5, delay: index * 0.08 }}
                            viewport={{ once: true }}
                        >
                            <ProjectCard project={project} />
                        </motion.div>
                    ))}
                </div>

                {filtered.length === 0 && (
                    <div className="text-center py-16 text-slate dark:text-slate-dark font-mono text-xs border border-dashed border-line dark:border-line-dark mt-6">
                        No projects found for this filter.
                    </div>
                )}
            </div>
        </section>
    );
}