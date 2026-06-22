import { useState, useEffect } from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import { motion, AnimatePresence } from 'framer-motion';
import { FiMenu, FiX, FiMoon, FiSun, FiArrowUpRight } from 'react-icons/fi';

export default function SiteLayout({ title, children }) {
    const { url } = usePage();
    const [isDark, setIsDark] = useState(true);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

    useEffect(() => {
        document.documentElement.classList.toggle('dark', isDark);
    }, [isDark]);

    const navigation = [
        { name: 'Index', href: '/' },
        { name: 'Releases', href: '/portfolio' },
    ];

    const isActive = (href) => (href === '/' ? url === '/' : url.startsWith(href));

    return (
        <div className="min-h-screen bg-paper dark:bg-night text-ink dark:text-paper-dark font-sans antialiased selection:bg-signal/20">
            <Head title={title} />

            <nav className="fixed top-0 w-full z-50 bg-paper/90 dark:bg-night/90 backdrop-blur-sm border-b border-line dark:border-line-dark">
                <div className="max-w-5xl mx-auto px-6 lg:px-0 lg:ml-40 lg:pr-12 h-20 flex justify-between items-center">
                    <Link href="/" className="flex items-center gap-2 group">
                        <div className="font-mono text-sm font-bold text-signal dark:text-signal-dark">
                            [<span className="text-ink dark:text-paper-dark group-hover:text-signal dark:group-hover:text-signal-dark transition-colors">AH</span>]
                        </div>
                        <span className="font-mono text-xs uppercase tracking-[0.2em] text-ink dark:text-paper-dark font-bold">
                            aiman hakim
                        </span>
                    </Link>

                    <div className="hidden md:flex items-center gap-8">
                        {navigation.map((item) => (
                            <Link
                                key={item.name}
                                href={item.href}
                                className={`font-mono text-[10px] uppercase tracking-widest transition-colors ${
                                    isActive(item.href)
                                        ? 'text-ink dark:text-paper-dark font-bold'
                                        : 'text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark'
                                }`}
                            >
                                {item.name}
                            </Link>
                        ))}
                        <button
                            onClick={() => setIsDark(!isDark)}
                            aria-label="Toggle theme"
                            className="text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark transition-colors cursor-pointer"
                        >
                            {isDark ? <FiSun size={15} /> : <FiMoon size={15} />}
                        </button>
                        <a
                            href="/#contact"
                            className="inline-flex items-center gap-1.5 px-4 py-2 border border-ink dark:border-paper-dark text-ink dark:text-paper-dark font-mono text-[10px] uppercase tracking-widest rounded-none hover:bg-ink hover:text-paper dark:hover:bg-paper-dark dark:hover:text-night transition-colors"
                        >
                            Get in touch <FiArrowUpRight size={12} />
                        </a>
                    </div>

                    <div className="flex items-center gap-4 md:hidden">
                        <button onClick={() => setIsDark(!isDark)} aria-label="Toggle theme" className="text-slate dark:text-slate-dark cursor-pointer">
                            {isDark ? <FiSun size={16} /> : <FiMoon size={16} />}
                        </button>
                        <button onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)} aria-label="Toggle menu" className="text-slate dark:text-slate-dark cursor-pointer">
                            {isMobileMenuOpen ? <FiX size={18} /> : <FiMenu size={18} />}
                        </button>
                    </div>
                </div>

                <AnimatePresence>
                    {isMobileMenuOpen && (
                        <motion.div
                            initial={{ opacity: 0, height: 0 }}
                            animate={{ opacity: 1, height: 'auto' }}
                            exit={{ opacity: 0, height: 0 }}
                            transition={{ duration: 0.2 }}
                            className="md:hidden border-b border-line dark:border-line-dark bg-paper dark:bg-night overflow-hidden"
                        >
                            <div className="px-6 py-6 flex flex-col gap-4">
                                {navigation.map((item) => (
                                    <Link
                                        key={item.name}
                                        href={item.href}
                                        onClick={() => setIsMobileMenuOpen(false)}
                                        className="font-mono text-[10px] uppercase tracking-widest text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark"
                                    >
                                        {item.name}
                                    </Link>
                                ))}
                                <a
                                    href="/#contact"
                                    onClick={() => setIsMobileMenuOpen(false)}
                                    className="font-mono text-[10px] uppercase tracking-widest text-ink dark:text-paper-dark font-bold"
                                >
                                    Get in touch
                                </a>
                            </div>
                        </motion.div>
                    )}
                </AnimatePresence>
            </nav>

            <main className="pt-20">{children}</main>

            <footer className="border-t border-line dark:border-line-dark py-12 bg-paper dark:bg-night">
                <div className="max-w-5xl mx-auto px-6 lg:px-0 lg:ml-40 lg:pr-12 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                    <p className="font-mono text-[10px] uppercase tracking-wider text-slate dark:text-slate-dark">
                        © {new Date().getFullYear()} Muhammad Aiman Hakim — UX/UI & Web Development
                    </p>
                    <div className="flex gap-6 font-mono text-[10px] uppercase tracking-wider text-slate dark:text-slate-dark">
                        <a href="/#contact" className="hover:text-ink dark:hover:text-paper-dark transition-colors">
                            Contact
                        </a>
                        <Link href="/portfolio" className="hover:text-ink dark:hover:text-paper-dark transition-colors">
                            Releases
                        </Link>
                    </div>
                </div>
            </footer>
        </div>
    );
}