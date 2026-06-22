import SiteLayout from '@/Layouts/SiteLayout';
import Hero from '@/Components/Hero';
import Skills from '@/Components/Skills';
import Experience from '@/Components/Experience';
import Projects from '@/Components/Projects';
import Contact from '@/Components/Contact';
import SectionRail from '@/Components/SectionRail';

const SECTIONS = [
    { id: 'intro', code: '00', label: 'Intro' },
    { id: 'stack', code: '01', label: 'Stack' },
    { id: 'log', code: '02', label: 'Log' },
    { id: 'releases', code: '03', label: 'Releases' },
    { id: 'contact', code: '04', label: 'Contact' },
];

export default function Home({ profile, skills, experiences, projects }) {
    return (
        <SiteLayout title="Aiman — Software Developer & UX Designer">
            <SectionRail sections={SECTIONS} />
            <Hero profile={profile} />
            <Skills skills={skills} />
            <Experience experiences={experiences} />
            <Projects projects={projects} title="Featured Deployments" />
            <Contact />
        </SiteLayout>
    );
}