import { Link } from '@inertiajs/react';
import SiteLayout from '@/Layouts/SiteLayout';
import PageMark from '@/Components/PageMark';
import { motion } from 'framer-motion';
import { FiArrowLeft, FiGithub, FiExternalLink, FiArrowRight } from 'react-icons/fi';

export default function PortfolioShow({ project, next, previous }) {
    if (!project) return null;

    return (
        <SiteLayout title={project.title}>
            <PageMark code="DOC" label={project.title} />

            <article className="py-20 sm:py-28 bg-paper dark:bg-night min-h-screen">
                <div className="max-w-3xl mx-auto px-6 lg:px-0 lg:ml-40 lg:pr-12">
                    <Link
                        href="/portfolio"
                        className="inline-flex items-center gap-1.5 font-mono text-[10px] uppercase tracking-widest text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark transition-colors mb-10"
                    >
                        <FiArrowLeft size={10} /> back to index
                    </Link>

                    <motion.div initial={{ opacity: 0, y: 10 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.4 }}>
                        <p className="font-mono text-[10px] tracking-[0.25em] text-slate dark:text-slate-dark uppercase mb-3">
                            SHIPPED
                        </p>
                        <h1 className="font-sans font-black text-3xl md:text-4xl tracking-tight text-ink dark:text-paper-dark uppercase mb-4">
                            {project.title}
                        </h1>

                        {project.tech_stack_array && (
                            <div className="flex flex-wrap gap-2 mb-10">
                                {project.tech_stack_array.map((tech) => (
                                    <span
                                        key={tech}
                                        className="px-2 py-0.5 font-mono text-[9px] uppercase tracking-wide text-slate dark:text-slate-dark border border-line dark:border-line-dark rounded-none"
                                    >
                                        {tech.trim()}
                                    </span>
                                ))}
                            </div>
                        )}
                    </motion.div>

                    <div className="border border-line dark:border-line-dark bg-line/20 dark:bg-line-dark/20 mb-10 aspect-[16/9] overflow-hidden rounded-none">
                        {project.thumbnail ? (
                            <img src={`/storage/${project.thumbnail}`} alt={project.title} className="w-full h-full object-cover grayscale" />
                        ) : (
                            <div className="w-full h-full flex items-center justify-center font-mono text-xs text-slate dark:text-slate-dark">
                                no preview
                            </div>
                        )}
                    </div>

                    {project.description && (
                        <div className="text-sm text-slate dark:text-slate-dark leading-relaxed space-y-4 mb-10 pb-10 border-b border-line dark:border-line-dark">
                            <p>{project.description}</p>
                        </div>
                    )}

                    <div className="flex flex-wrap items-center gap-4 mb-16">
                        {project.project_url && (
                            <a
                                href={project.project_url}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="inline-flex items-center gap-1.5 px-6 py-3.5 bg-signal text-paper dark:text-night font-mono text-[10px] uppercase tracking-widest rounded-none border border-signal hover:bg-transparent hover:text-signal transition-all cursor-pointer font-bold"
                            >
                                <FiExternalLink size={12} /> live deploy
                            </a>
                        )}
                        {project.github_url && (
                            <a
                                href={project.github_url}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="inline-flex items-center gap-1.5 px-6 py-3.5 border border-line dark:border-line-dark font-mono text-[10px] uppercase tracking-widest text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark hover:border-ink dark:hover:border-paper-dark transition-all cursor-pointer rounded-none"
                            >
                                <FiGithub size={12} /> source
                            </a>
                        )}
                    </div>

                    <div className="flex justify-between items-center border-t border-line dark:border-line-dark pt-8">
                        {previous ? (
                            <Link
                                href={route('portfolio.show', previous.slug)}
                                className="group flex items-center gap-3 text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark transition-colors"
                            >
                                <FiArrowLeft size={12} className="group-hover:-translate-x-0.5 transition-transform" />
                                <div className="text-left">
                                    <div className="font-mono text-[9px] uppercase tracking-wider">prev</div>
                                    <div className="font-sans text-sm font-bold uppercase text-ink dark:text-paper-dark group-hover:text-signal transition-colors">{previous.title}</div>
                                </div>
                            </Link>
                        ) : (
                            <div />
                        )}

                        {next && (
                            <Link
                                href={route('portfolio.show', next.slug)}
                                className="group flex items-center gap-3 text-right text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark transition-colors"
                            >
                                <div className="text-right">
                                    <div className="font-mono text-[9px] uppercase tracking-wider">next</div>
                                    <div className="font-sans text-sm font-bold uppercase text-ink dark:text-paper-dark group-hover:text-signal transition-colors">{next.title}</div>
                                </div>
                                <FiArrowRight size={12} className="group-hover:translate-x-0.5 transition-transform" />
                            </Link>
                        )}
                    </div>
                </div>
            </article>
        </SiteLayout>
    );
}