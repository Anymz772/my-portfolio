import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';

export default function ProjectCard({ project }) {
    return (
        <Link href={route('portfolio.show', project.slug)} className="block">
            <motion.div
                whileHover={{ scale: 1.01 }}
                transition={{ duration: 0.3 }}
                className="group relative aspect-square w-full bg-line/20 dark:bg-line-dark/20 border border-line dark:border-line-dark hover:border-signal group-hover:border-signal hover:shadow-[0_0_15px_rgba(0,240,255,0.15)] group-hover:shadow-[0_0_15px_rgba(0,240,255,0.15)] transition-all duration-300 rounded-none overflow-hidden cursor-pointer"
            >
                {/* Image */}
                {project.thumbnail ? (
                    <img
                        src={`/storage/${project.thumbnail}`}
                        alt={project.title}
                        className="w-full h-full object-cover grayscale transition duration-500 group-hover:scale-105 group-hover:grayscale-0"
                    />
                ) : (
                    <div className="w-full h-full flex flex-col justify-between p-6 bg-paper dark:bg-night border border-line dark:border-line-dark select-none">
                        <span className="font-mono text-[9px] uppercase tracking-wider text-slate dark:text-slate-dark">No Image</span>
                        <div className="text-center font-mono text-3xl font-black tracking-widest text-slate/20 dark:text-slate-dark/20 uppercase">
                            AH
                        </div>
                        <span className="font-mono text-[9px] uppercase tracking-wider text-slate dark:text-slate-dark">DOC</span>
                    </div>
                )}

                {/* Monochrome hover overlay */}
                <div className="absolute inset-0 bg-[#07080A]/95 flex flex-col justify-between p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 text-white">
                    <div className="space-y-1">
                        <span className="font-mono text-[9px] uppercase tracking-widest text-slate dark:text-slate-dark">
                            {project.tech_stack ? project.tech_stack.split(',').slice(0, 3).join(', ') : ''}
                        </span>
                        <h4 className="font-sans text-lg font-black uppercase leading-tight mt-2 text-white">
                            {project.title}
                        </h4>
                    </div>

                    <div className="flex justify-between items-end border-t border-line dark:border-line-dark pt-4">
                        <span className="font-mono text-[9px] uppercase tracking-widest border-b border-signal pb-0.5 font-bold text-signal">
                            View Case Study
                        </span>
                        <span className="font-mono text-[9px] tracking-wider text-slate dark:text-slate-dark">
                            2026
                        </span>
                    </div>
                </div>
            </motion.div>
        </Link>
    );
}