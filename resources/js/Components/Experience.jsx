import { motion } from 'framer-motion';

export default function Experience({ experiences }) {
    if (!experiences || experiences.length === 0) return null;

    return (
        <section id="log" className="py-24 bg-paper dark:bg-night border-t border-line dark:border-line-dark">
            <div className="max-w-3xl mx-auto px-6 lg:px-0 lg:ml-40 lg:pr-12">
                {/* Section header */}
                <motion.div
                    initial={{ opacity: 0, y: 16 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.5 }}
                    viewport={{ once: true }}
                    className="mb-16"
                >
                    <p className="font-mono text-[10px] tracking-[0.25em] text-slate dark:text-slate-dark uppercase mb-3">
                        03 EXPERIENCE
                    </p>
                    <h2 className="font-sans font-black text-3xl md:text-4xl tracking-tight text-ink dark:text-paper-dark uppercase">
                        Places I've worked
                    </h2>
                </motion.div>

                {/* Editorial Split Experience Timeline */}
                <div className="space-y-12">
                    {experiences.map((exp, index) => {
                        const startYear = exp.start_date ? new Date(exp.start_date).getFullYear() : '';
                        const endYear = exp.end_date ? new Date(exp.end_date).getFullYear() : 'Present';

                        return (
                            <motion.div
                                key={exp.id}
                                initial={{ opacity: 0, y: 20 }}
                                whileInView={{ opacity: 1, y: 0 }}
                                transition={{ duration: 0.5, delay: index * 0.08 }}
                                viewport={{ once: true }}
                                className="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-8 border-b border-line dark:border-line-dark pb-10 last:border-b-0 last:pb-0"
                            >
                                {/* Left side: Years */}
                                <div className="md:col-span-4 flex flex-row md:flex-col justify-between md:justify-start">
                                    <span className="font-mono text-sm md:text-base font-bold text-signal tracking-wider leading-none">
                                        {startYear} — {endYear}
                                    </span>
                                    {exp.location && (
                                        <span className="font-mono text-[9px] uppercase tracking-wider text-slate dark:text-slate-dark mt-1">
                                            {exp.location}
                                        </span>
                                    )}
                                </div>

                                {/* Right side: Role Details */}
                                <div className="md:col-span-8 space-y-3">
                                    <div>
                                        <h3 className="font-sans text-base font-bold text-ink dark:text-paper-dark leading-snug">
                                            {exp.role}
                                        </h3>
                                        <p className="font-mono text-[10px] uppercase tracking-wider text-slate dark:text-slate-dark mt-1 font-bold">
                                            {exp.company}
                                        </p>
                                    </div>

                                    {exp.description && (
                                        <p className="text-sm text-slate dark:text-slate-dark leading-relaxed">
                                            {exp.description}
                                        </p>
                                    )}
                                </div>
                            </motion.div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}