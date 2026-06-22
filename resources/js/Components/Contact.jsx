import { motion } from 'framer-motion';
import ContactForm from './ContactForm';
import { FiMail, FiMapPin, FiPhone, FiGithub, FiLinkedin } from 'react-icons/fi';

const INFO_ITEMS = [
    { icon: FiMail,   label: 'Email',    value: 'aiman@example.com' },
    { icon: FiMapPin, label: 'Location', value: 'Ipoh, Perak, Malaysia' },
    { icon: FiPhone,  label: 'Phone',    value: '+60 12-345 6789' },
];

export default function Contact() {
    return (
        <section id="contact" className="py-24 bg-paper dark:bg-night border-t border-line dark:border-line-dark">
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
                        CONTACT
                    </p>
                    <h2 className="font-sans font-black text-3xl md:text-4xl tracking-tight text-ink dark:text-paper-dark uppercase">
                        Let's work together
                    </h2>
                </motion.div>

                <div className="grid grid-cols-1 lg:grid-cols-5 gap-12">
                    {/* Left: info panel */}
                    <motion.div
                        initial={{ opacity: 0, x: -20 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        transition={{ duration: 0.5 }}
                        viewport={{ once: true }}
                        className="lg:col-span-2 space-y-8"
                    >
                        <p className="text-sm text-slate dark:text-slate-dark leading-relaxed font-sans">
                            Open to freelance projects and full-time opportunities. Send me a message and I'll get back to you within 24 hours.
                        </p>

                        {/* Contact items */}
                        <div className="space-y-4">
                            {INFO_ITEMS.map(({ icon: Icon, label, value }) => (
                                <div key={label} className="flex items-center gap-4">
                                    <div className="w-9 h-9 rounded-none border border-line dark:border-line-dark flex items-center justify-center flex-shrink-0 bg-paper/20 dark:bg-night/20">
                                        <Icon size={14} className="text-ink dark:text-paper-dark" />
                                    </div>
                                    <div>
                                        <p className="font-mono text-[9px] uppercase tracking-wider text-slate dark:text-slate-dark">{label}</p>
                                        <p className="text-sm font-bold text-ink dark:text-paper-dark">{value}</p>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Divider */}
                        <div className="border-t border-line dark:border-line-dark pt-6">
                            <p className="font-mono text-[10px] uppercase tracking-wider text-slate dark:text-slate-dark mb-3">Find me on</p>
                            <div className="flex gap-2.5">
                                {[
                                    { icon: FiGithub,   href: 'https://github.com/m-aiman', label: 'GitHub' },
                                    { icon: FiLinkedin, href: 'https://linkedin.com/in/m-aiman', label: 'LinkedIn' },
                                ].map(({ icon: Icon, href, label }) => (
                                    <a
                                        key={label}
                                        href={href}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label={label}
                                        className="w-9 h-9 rounded-none border border-line dark:border-line-dark flex items-center justify-center text-slate dark:text-slate-dark hover:text-ink dark:hover:text-paper-dark hover:border-ink dark:hover:border-paper-dark transition-all duration-300 bg-paper/20 dark:bg-night/20"
                                    >
                                        <Icon size={14} />
                                    </a>
                                ))}
                            </div>
                        </div>
                    </motion.div>

                    {/* Right: form */}
                    <motion.div
                        initial={{ opacity: 0, x: 20 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        transition={{ duration: 0.5, delay: 0.1 }}
                        viewport={{ once: true }}
                        className="lg:col-span-3 bg-paper/30 dark:bg-night/30 rounded-none border border-line dark:border-line-dark p-6"
                    >
                        <ContactForm />
                    </motion.div>
                </div>
            </div>
        </section>
    );
}