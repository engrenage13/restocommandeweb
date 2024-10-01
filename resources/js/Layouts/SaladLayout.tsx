import { PropsWithChildren } from 'react';
import { Head } from '@inertiajs/react';
import Footer from '@/Components/Footer';
import NavBar from '@/Components/NavBar';

export default function Salad({ children, title }: PropsWithChildren<{ title?: string }>) {
  return (
    <>
      <Head title={title} />
      <div className="min-h-screen bg-gray-100">
        <NavBar />

        <main className="flex flex-col grow min-h-full pb-12">
          {children}
        </main>

        {/*<Footer />*/}
      </div>
    </>
  );
}
