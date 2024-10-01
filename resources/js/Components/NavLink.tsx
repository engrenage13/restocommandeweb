import { Link, InertiaLinkProps } from '@inertiajs/react';

export default function NavLink({ active = false, className = '', children, ...props }: InertiaLinkProps & { active: boolean }) {
  return (
    <Link
      {...props}
      className={
        'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-200 ease-in-out focus:outline-none h-full ' +
        (active
          ? 'border-green-400 text-gray-900 focus:border-green-700 '
          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-green-300 hover:bg-green-50 focus:text-gray-700 focus:border-green-300 focus:bg-green-50 ') +
        className
      }
    >
      {children}
    </Link>
  );
}
