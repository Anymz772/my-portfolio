import { useForm } from '@inertiajs/react';
import { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { FiSend, FiCheckCircle } from 'react-icons/fi';

function Field({ label, error, required, children }) {
    return (
        <div className="space-y-1">
            <label className="block font-mono text-[9px] uppercase tracking-wider text-slate dark:text-slate-dark">
                {label} {required && <span className="text-ink dark:text-paper-dark font-bold">*</span>}
            </label>
            {children}
            <AnimatePresence>
                {error && (
                    <motion.p
                        initial={{ opacity: 0, height: 0 }}
                        animate={{ opacity: 1, height: 'auto' }}
                        exit={{ opacity: 0, height: 0 }}
                        className="mt-1 font-mono text-[9px] text-ink dark:text-paper-dark font-semibold"
                    >
                        {error}
                    </motion.p>
                )}
            </AnimatePresence>
        </div>
    );
}

const inputClass = (hasError) =>
    `w-full bg-transparent border-t-0 border-x-0 border-b transition-all text-ink dark:text-paper-dark placeholder-slate/30 dark:placeholder-slate-dark/30 focus:outline-none focus:ring-0 focus:border-signal py-2 rounded-none text-sm ${
        hasError
            ? 'border-ink dark:border-paper-dark font-bold'
            : 'border-line dark:border-line-dark hover:border-slate dark:hover:border-slate-dark'
    }`;

export default function ContactForm() {
    const { data, setData, post, processing, errors, reset } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        message: '',
    });

    const [success, setSuccess] = useState(false);

    const handleSubmit = () => {
        post('/contact', {
            onSuccess: () => {
                setSuccess(true);
                reset();
                setTimeout(() => setSuccess(false), 5000);
            },
        });
    };

    return (
        <div className="space-y-6">
            {/* Name row */}
            <div className="grid grid-cols-2 gap-4">
                <Field label="First name" error={errors.first_name} required>
                    <input
                        type="text"
                        value={data.first_name}
                        onChange={(e) => setData('first_name', e.target.value)}
                        placeholder="Ahmad"
                        className={inputClass(!!errors.first_name)}
                    />
                </Field>
                <Field label="Last name" error={errors.last_name} required>
                    <input
                        type="text"
                        value={data.last_name}
                        onChange={(e) => setData('last_name', e.target.value)}
                        placeholder="Eman"
                        className={inputClass(!!errors.last_name)}
                    />
                </Field>
            </div>

            {/* Email */}
            <Field label="Email" error={errors.email} required>
                <input
                    type="email"
                    value={data.email}
                    onChange={(e) => setData('email', e.target.value)}
                    placeholder="you@email.com"
                    className={inputClass(!!errors.email)}
                />
            </Field>

            {/* Phone */}
            <Field label="Phone" error={errors.phone}>
                <input
                    type="tel"
                    value={data.phone}
                    onChange={(e) => setData('phone', e.target.value)}
                    placeholder="+60 12-345 6789"
                    className={inputClass(!!errors.phone)}
                />
            </Field>

            {/* Message */}
            <Field label="Message" error={errors.message} required>
                <textarea
                    rows={4}
                    value={data.message}
                    onChange={(e) => setData('message', e.target.value)}
                    placeholder="Tell me about your project..."
                    className={`${inputClass(!!errors.message)} resize-none`}
                />
            </Field>

            {/* Submit */}
            <motion.button
                onClick={handleSubmit}
                disabled={processing}
                whileTap={{ scale: 0.99 }}
                className="w-full py-3.5 flex items-center justify-center gap-2 bg-signal text-paper dark:text-night border border-signal font-mono text-[10px] uppercase tracking-widest rounded-none hover:bg-transparent hover:text-signal transition-all cursor-pointer font-bold disabled:opacity-50"
            >
                {processing ? (
                    <>
                        <svg className="animate-spin h-4 w-4 text-paper dark:text-night" fill="none" viewBox="0 0 24 24">
                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        Sending...
                    </>
                ) : success ? (
                    <>
                        <FiCheckCircle size={14} /> Sent!
                    </>
                ) : (
                    <>
                        <FiSend size={12} /> Send Message
                    </>
                )}
            </motion.button>

            {/* Success banner */}
            <AnimatePresence>
                {success && (
                    <motion.div
                        initial={{ opacity: 0, y: 6 }}
                        animate={{ opacity: 1, y: 0 }}
                        exit={{ opacity: 0, y: 6 }}
                        className="flex items-center gap-2 px-4 py-3 bg-paper dark:bg-night border border-line dark:border-line-dark rounded-none font-mono text-xs text-ink dark:text-paper-dark"
                    >
                        <FiCheckCircle size={15} className="text-ink dark:text-paper-dark" />
                        Message sent — I'll get back to you soon.
                    </motion.div>
                )}
            </AnimatePresence>
        </div>
    );
}