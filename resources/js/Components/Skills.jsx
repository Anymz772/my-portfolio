import { motion } from 'framer-motion';

export default function Skills({ skills }) {
    if (!skills || Object.keys(skills).length === 0) return null;

    const categories = Object.keys(skills);

    return (
        <section id="stack" className="py-24 bg-paper dark:bg-night border-t border-line dark:border-line-dark">
            <div className="max-w-5xl mx-auto px-6 lg:px-0 lg:ml-40 lg:pr-12">
                {/* Section header */}
                <motion.div
                    initial={{ opacity: 0, y: 16 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.5 }}
                    viewport={{ once: true }}
                    className="mb-16"
                >
                    <p className="font-mono text-[10px] tracking-[0.25em] text-slate dark:text-slate-dark uppercase mb-3">
                        01 PROFESSIONAL
                    </p>
                    <h2 className="font-sans font-black text-3xl md:text-4xl tracking-tight text-ink dark:text-paper-dark uppercase">
                        My knowledge level in software
                    </h2>
                </motion.div>

                <div className="space-y-16">
                    {categories.map((category, catIdx) => (
                        <motion.div
                             key={category}
                             initial={{ opacity: 0, y: 20 }}
                             whileInView={{ opacity: 1, y: 0 }}
                             transition={{ duration: 0.5, delay: catIdx * 0.08 }}
                             viewport={{ once: true }}
                         >
                             <h3 className="font-mono text-xs uppercase tracking-widest text-ink dark:text-paper-dark mb-8 pb-1 border-b border-line dark:border-line-dark font-bold">
                                 {category}
                             </h3>
                             <div className="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                                 {skills[category].map((skill, idx) => {
                                     const pct = skill.percentage ?? 50;

                                     return (
                                         <motion.div
                                             key={skill.id}
                                             initial={{ opacity: 0, y: 10 }}
                                             whileInView={{ opacity: 1, y: 0 }}
                                             transition={{ duration: 0.4, delay: idx * 0.04 }}
                                             viewport={{ once: true }}
                                             className="space-y-2.5"
                                         >
                                             <div className="flex justify-between items-center font-mono text-[11px] uppercase tracking-wider text-ink dark:text-paper-dark font-semibold">
                                                 <span>{skill.name}</span>
                                                 <span className="text-slate dark:text-slate-dark">{pct}%</span>
                                             </div>
                                             
                                             {/* Minimal outline progress bar */}
                                             <div className="w-full h-[6px] border border-line dark:border-line-dark rounded-none overflow-hidden bg-transparent p-[1px]">
                                                 <motion.div
                                                     initial={{ width: 0 }}
                                                     whileInView={{ width: `${pct}%` }}
                                                     transition={{ duration: 0.8, ease: 'easeOut', delay: idx * 0.05 }}
                                                     viewport={{ once: true }}
                                                     className="h-full bg-signal rounded-none"
                                                 />
                                             </div>
                                         </motion.div>
                                     );
                                 })}
                             </div>
                         </motion.div>
                     ))}
                </div>
            </div>
        </section>
    );
}