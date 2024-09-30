import { Link, usePage } from "@inertiajs/react";
import NavLink from "./NavLink";
import { useState } from "react";
import ResponsiveNavLink from "./ResponsiveNavLink";
import DropDownNavButton from "./DropDownNavButton";
import { ILink } from "@/types/ui/types";

export default function NavBar() {
  const user = usePage().props.auth.user ?? undefined;
  const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);
  
  const links: ILink[] = [];

  return (
    <nav className="bg-white border-b border-gray-100">
      <div className="max-w-7xl mx-auto px-2 sm:px-3">
        <div className="flex justify-between h-12">
          <div className="flex">
            <div className="shrink-0 flex items-center">
              <Link href="/">
                Resto Commande
              </Link>
            </div>
            <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              {links.map(x => 
                <NavLink href={route(x.route)} active={route().current(x.route)}>
                  {x.label}
                </NavLink>
              )}
            </div>
          </div>

          {links.length > 0 &&
            <div className="-me-2 flex items-center sm:hidden">
              <button
                onClick={() => setShowingNavigationDropdown((previousState) => !previousState)}
                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
              >
                <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path
                    className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    className={showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          }

          <div className="gap-1 sm:flex sm:justify-start sm:items-center sm:ms-6">
            {!user ?
              <>
                <NavLink href={route('login')} active={route().current('login')}>
                  Connexion
                </NavLink>
                <NavLink href={route('register')} active={route().current('register')}>
                  Inscription
                </NavLink>
              </>
              :
              <DropDownNavButton 
                href={route('profile.show')} 
                active={route().current('profile.show')}
                links={[
                  {route: 'profile.show', label: 'Mon profil'},
                  {route: 'profile.edit', label: 'Modifier mon profil'},
                  {route: 'logout', label: 'Déconnexion', color: 'red'}
                ]}
              >
                {user.firstname}
              </DropDownNavButton>
            }
          </div>
        </div>
      </div>

      <div className={(showingNavigationDropdown ? 'block' : 'hidden') + ' absolute bg-slate-200 w-full h-full sm:hidden'}>
        <div className="pt-2 pb-3 space-y-1 bg-slate-200">
          {links.map(x => 
            <ResponsiveNavLink href={route(x.route)} active={route().current(x.route)}>
              {x.label}
            </ResponsiveNavLink>
          )}
        </div>
      </div>
    </nav>
  );
}