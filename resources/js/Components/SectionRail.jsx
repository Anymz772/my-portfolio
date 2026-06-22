import { useState, useEffect } from 'react';
import { motion } from 'framer-motion';

export default function SectionRail({ sections }) {
    const [activeSection, setActiveSection] = useState(sections[0]?.id || '');

    useEffect(() => {
        const observerOptions = {
            root: null,
            rootMargin: '-30% 0px -60% 0px', // Trigger when section occupies the middle portion of the screen
            threshold: 0,
        };

        const handleIntersection = (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    setActiveSection(entry.target.id);
                }
            });
        };

        const observer = new IntersectionObserver(handleIntersection, observerOptions);

        sections.forEach((section) => {
            const element = document.getElementById(section.id);
            if (element) {
                observer.observe(element);
            }
        });

        return () => {
            sections.forEach((section) => {
                const element = document.getElementById(section.id);
                if (element) {
                    observer.unobserve(element);
                }
            });
        };
    }, [sections]);

    const handleScroll = (id) => {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    };

    return (
        <aside className="fixed left-0 top-0 h-screen w-40 hidden lg:flex flex-col justify-between py-20 border-r border-line dark:border-line-dark px-6 z-40 bg-paper/50 dark:bg-night/50 backdrop-blur-[2px]">
            {/* Header placeholder matching site branding */}
            <div className="font-mono text-[10px] tracking-widest text-slate dark:text-slate-dark uppercase">
                Navigation
            </div>

            {/* Stepper container */}
            <div className="relative flex flex-col gap-6 my-auto pl-2">
                {/* Visual vertical connector line */}
                <div className="absolute left-[9px] top-2 bottom-2 w-[1px] bg-line dark:bg-line-dark" />

                {sections.map((section) => {
                    const isActive = activeSection === section.id;
                    return (
                        <button
                            key={section.id}
                            onClick={() => handleScroll(section.id)}
                            className="group relative flex items-center gap-4 text-left font-mono focus:outline-none cursor-pointer"
                        >
                            {/* Dot / Indicator */}
                            <div className="relative z-10 flex items-center justify-center">
                                <motion.div
                                    animate={{
                                        scale: isActive ? 1.2 : 1,
                                        backgroundColor: isActive ? 'var(--color-signal)' : 'transparent',
                                        borderColor: isActive ? 'var(--color-signal)' : 'var(--color-slate)',
                                    }}
                                    className={`w-[6px] h-[6px] transition-colors duration-300 ${
                                        isActive
                                            ? 'bg-signal border-signal'
                                            : 'border-slate dark:border-slate-dark group-hover:border-signal dark:group-hover:border-signal-dark'
                                    }`}
                                />
                            </div>

                            {/* Label content */}
                            <div className="flex flex-col">
                                <span
                                    className={`text-[9px] tracking-widest font-semibold ${
                                        isActive
                                            ? 'text-signal'
                                            : 'text-slate-dark dark:text-slate hover:text-signal dark:hover:text-signal-dark'
                                    }`}
                                >
                                    {section.code}
                                </span>
                                <span
                                    className={`text-[10px] uppercase tracking-wider font-semibold transition-colors duration-200 ${
                                        isActive
                                            ? 'text-signal font-bold'
                                            : 'text-slate dark:text-slate-dark group-hover:text-signal dark:group-hover:text-signal-dark'
                                    }`}
                                >
                                    {section.label}
                                </span>
                            </div>
                        </button>
                    );
                })}
            </div>

            {/* Footer mark */}
            <div className="font-mono text-[9px] text-slate/50 dark:text-slate-dark/50">
                SCROLL_REP
            </div>
        </aside>
    );
}
