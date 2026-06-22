import { Link } from '@inertiajs/react';
import { FiArrowLeft } from 'react-icons/fi';

export default function PageMark({ code, label }) {
    return (
        <aside className="fixed left-0 top-0 h-screen w-40 hidden lg:flex flex-col justify-between py-20 border-r border-line dark:border-line-dark px-6 z-40 bg-paper/50 dark:bg-night/50 backdrop-blur-[2px]">
            {/* Top link / Navigation */}
            <div>
                <Link
                    href="/"
                    className="inline-flex items-center gap-1.5 font-mono text-[10px] tracking-widest text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark uppercase transition-colors"
                >
                    <FiArrowLeft size={10} /> Home
                </Link>
            </div>

            {/* Typography Indicator */}
            <div className="flex flex-col items-start gap-4 my-auto pl-2 border-l border-line dark:border-line-dark py-4">
                {/* Code badge */}
                <div className="font-mono text-[10px] font-bold px-2 py-0.5 border border-signal text-signal tracking-wider rounded-none bg-signal/5">
                    {code}
                </div>

                {/* Vertical text label */}
                <div 
                    className="font-mono text-[10px] uppercase tracking-widest text-slate dark:text-slate-dark select-none font-bold"
                    style={{
                        writingMode: 'vertical-rl',
                        transform: 'rotate(180deg)',
                    }}
                >
                    {label}
                </div>
            </div>

            {/* Footer mark */}
            <div className="font-mono text-[9px] text-slate/50 dark:text-slate-dark/50">
                META_SYS
            </div>
        </aside>
    );
}
