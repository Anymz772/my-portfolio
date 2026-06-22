import { motion, useScroll, useTransform } from 'framer-motion';
import { useRef } from 'react';
import { FiGithub, FiLinkedin, FiArrowDown, FiDownload } from 'react-icons/fi';

export default function Hero({ profile }) {
    const ref = useRef(null);
    const { scrollYProgress } = useScroll({
        target: ref,
        offset: ['start start', 'end start'],
    });
    const opacity = useTransform(scrollYProgress, [0, 0.5], [1, 0]);
    const y = useTransform(scrollYProgress, [0, 1], ['0%', '15%']);

    if (!profile) return null;

    return (
        <section ref={ref} id="intro" className="relative min-h-screen flex flex-col bg-paper dark:bg-night">
            {/* Subtle grid background */}
            <div
                className="absolute inset-0 pointer-events-none"
                style={{
                    backgroundImage:
                        'linear-gradient(var(--color-line, rgba(222,218,205,0.25)) 1px, transparent 1px), linear-gradient(90deg, rgba(222,218,205,0.25) 1px, transparent 1px)',
                    backgroundSize: '48px 48px',
                }}
            />

            <motion.div
                style={{ opacity, y }}
                className="relative z-10 flex-1 max-w-5xl mx-auto px-6 lg:px-0 lg:ml-40 lg:pr-12 w-full flex items-center pt-28 pb-20"
            >
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center w-full">
                    {/* Left text column */}
                    <div className="lg:col-span-7 text-left flex flex-col justify-center">
                        <motion.div
                            initial={{ opacity: 0, y: -15 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.5 }}
                            className="font-mono text-[10px] tracking-[0.25em] text-signal uppercase mb-4"
                        >
                            {profile.role_title || 'UX/UI Designer & Developer'}
                        </motion.div>

                        <motion.h1
                            initial={{ opacity: 0, y: 20 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.6, delay: 0.15 }}
                            className="font-sans font-black text-5xl sm:text-6xl md:text-7xl tracking-tight text-ink uppercase leading-[1.05]"
                        >
                            I'm {profile.full_name}.
                        </motion.h1>
                        
                        <motion.h2
                            initial={{ opacity: 0, y: 20 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.6, delay: 0.25 }}
                            className="font-mono text-base sm:text-lg text-signal mt-4 font-bold uppercase tracking-wider"
                        >
                            // CREATING THOUGHTFUL INTERFACE SYSTEMS.
                        </motion.h2>

                        <motion.p
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ duration: 0.6, delay: 0.35 }}
                            className="mt-6 text-sm text-slate dark:text-slate-dark max-w-xl leading-relaxed font-mono"
                        >
                            {profile.bio || 'Passionate software engineer specializing in Laravel, Inertia, React, and modern web systems development.'}
                        </motion.p>

                        {/* Actions */}
                        <motion.div
                            initial={{ opacity: 0, y: 20 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.6, delay: 0.45 }}
                            className="flex flex-wrap items-center gap-4 mt-10"
                        >
                            <a
                                href="#releases"
                                className="inline-flex items-center px-6 py-3.5 bg-signal border border-signal text-paper dark:text-night font-mono text-[10px] uppercase tracking-widest rounded-none hover:bg-transparent hover:text-signal transition-all duration-300 cursor-pointer font-bold"
                            >
                                View My Work
                            </a>
                            {profile.cv_url && (
                                <a
                                    href={`/storage/${profile.cv_url}`}
                                    download
                                    className="inline-flex items-center gap-2 px-6 py-3.5 text-xs font-mono font-medium text-slate dark:text-slate-dark border border-line dark:border-line-dark rounded-none hover:text-ink dark:hover:text-paper-dark hover:border-slate dark:hover:border-slate-dark transition-colors"
                                >
                                    <FiDownload size={13} />
                                    Download CV
                                </a>
                            )}
                        </motion.div>

                        {/* Social Links */}
                        <motion.div
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ duration: 0.6, delay: 0.55 }}
                            className="flex items-center gap-5 mt-10"
                        >
                            {profile.github_url && (
                                <a
                                    href={profile.github_url}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark transition-colors"
                                    aria-label="GitHub"
                                >
                                    <FiGithub size={18} />
                                </a>
                            )}
                            {profile.linkedin_url && (
                                <a
                                    href={profile.linkedin_url}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark transition-colors"
                                    aria-label="LinkedIn"
                                >
                                    <FiLinkedin size={18} />
                                </a>
                            )}
                        </motion.div>
                    </div>

                    {/* Right portrait column */}
                    <div className="lg:col-span-5 flex justify-center items-center">
                        <motion.div
                            initial={{ scale: 0.95, opacity: 0 }}
                            animate={{ scale: 1, opacity: 1 }}
                            transition={{ duration: 0.7, delay: 0.25 }}
                            className="aspect-[3/4] w-full max-w-sm bg-line/20 dark:bg-line-dark/20 border border-line dark:border-line-dark p-2.5 rounded-none overflow-hidden relative shadow-sm"
                        >
                            {profile.profile_image ? (
                                <img
                                    src={`/storage/${profile.profile_image}`}
                                    alt={profile.full_name}
                                    className="w-full h-full object-cover border border-line dark:border-line-dark rounded-none grayscale"
                                />
                            ) : (
                                <div className="w-full h-full flex flex-col justify-between p-8 bg-paper/20 dark:bg-night/20 border border-line dark:border-line-dark relative font-mono text-[9px] uppercase tracking-wider text-slate dark:text-slate-dark select-none">
                                    <div className="absolute inset-0 pointer-events-none opacity-[0.03] dark:opacity-[0.05]"
                                         style={{
                                             backgroundImage: 'radial-gradient(circle, var(--color-signal) 1.5px, transparent 1.5px)',
                                             backgroundSize: '24px 24px'
                                         }}
                                    />
                                    <div className="flex justify-between items-start font-bold">
                                        <span className="text-signal">// MAIN_INIT</span>
                                        <span>SYS_ACTIVE</span>
                                    </div>
                                    <div className="my-auto text-center flex flex-col gap-2">
                                        <span className="text-5xl font-black text-ink dark:text-paper-dark">
                                            {profile.full_name.split(' ').map((n) => n[0]).join('').toUpperCase()}
                                        </span>
                                        <span className="text-[10px] text-signal font-bold tracking-widest">[ SOFTWARE_ENG ]</span>
                                    </div>
                                    <div className="flex justify-between items-end font-bold">
                                        <span>LOC // PERAK_MY</span>
                                        <span className="text-signal font-bold">V1.0.0</span>
                                    </div>
                                </div>
                            )}
                        </motion.div>
                    </div>
                </div>
            </motion.div>

            {/* Scroll indicator */}
            <motion.div
                className="relative z-10 flex justify-center pb-8"
                animate={{ y: [0, 6, 0] }}
                transition={{ repeat: Infinity, duration: 2.5, ease: 'easeInOut' }}
            >
                <a href="#stack" className="text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark transition-colors">
                    <FiArrowDown size={18} />
                </a>
            </motion.div>
        </section>
    );
}