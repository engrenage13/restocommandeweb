import { InertiaLinkProps } from '@inertiajs/react';
import Dropdown from './Dropdown';
import { ILink } from '@/types/ui/types';

export default function DropDownNavButton({ active = false, links = [], className = '', children, ...props }: InertiaLinkProps & { active: boolean, links: ILink[] }) {
  if (!active && links.length > 0) {
    let i = 0;
    while (i < links.length && !active) {
      active = route().current(links[i].route);
      i++;
    }
  }
  
  return (
    <Dropdown {...props}>
      <Dropdown.Trigger>
        <span className={'inline-flex items-center pl-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-200 ease-in-out focus:outline-none h-full ' +
          (active
            ? 'border-green-400 text-gray-900 focus:border-green-700 '
            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-green-300 focus:text-gray-700 focus:border-green-300 ') +
          className}
        >
          <button
            type="button"
            className="inline-flex items-center py-3 border border-transparent text-sm leading-4 font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
          >
            {children}
            <svg
              className="h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fillRule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clipRule="evenodd"
              />
            </svg>
          </button>
        </span>
      </Dropdown.Trigger>

      <Dropdown.Content>
        {links.map(x => 
          <Dropdown.Link 
            href={route(x.route)} 
            active={route().current(x.route)} 
            style={x.color ? {color: x.color} : {}}
          >
            {x.label}
          </Dropdown.Link>)
        }
      </Dropdown.Content>
    </Dropdown>
  );
}
