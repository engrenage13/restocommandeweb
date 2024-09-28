import { Link, Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import Footer from '@/Components/Footer';

export default function Welcome({ auth }: PageProps<{}>) {
  return (
    <>
      <Head title="Présentation" />
      <div className="bg-gray-50 text-black/50 flex flex-col dark:bg-black dark:text-white/50 min-h-screen">
        <header className="flex flex-row justify-between justify-items-center py-4 lg:py-2 grow-0">
          <p className="text-xl font-semibold text-green-600 m-0 ml-4">Resto Commande</p>
          <nav className="mr-4 flex flex-1 justify-end gap-3">
            {auth.user ? (
              <Link
                href={route('dashboard')}
                className="text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#2ab822] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
              >
                Tableau de bord
              </Link>
            ) : (
              <>
                <Link
                  href={route('login')}
                  className="text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#2ab822] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                  Me connecter
                </Link>
                <Link
                  href={route('register')}
                  className="text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#2ab822] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                  M'inscrire
                </Link>
              </>
            )}
          </nav>
        </header>

        <main className="flex justify-center justify-items-center grow my-60 lg:my-40">
          <h1 className="text-7xl lg:text-9xl font-bold text-green-700 light:underline">Bienvenue</h1>
        </main>

        <Footer />
      </div>
    </>
  );
}
