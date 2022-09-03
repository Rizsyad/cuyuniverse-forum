import {FaGithub, IoHomeOutline, HiMenuAlt2} from "react-icons/all";
import {useState} from "react";
import NavLink from "./NavLink";

const NavBar = () => {
  const [showMenu, setShowMenu] = useState(false);

  const setToggleMenu = () => setShowMenu(!showMenu);

  return (
    <nav className="sticky top-0 border-gray-200 bg-light-primary py-2 px-2 dark:bg-gray-900 sm:px-4">
      <div className="container mx-auto flex max-w-7xl flex-wrap items-center justify-between">
        <a href="/" className="flex items-center">
          <span className="self-center whitespace-nowrap text-2xl font-bold dark:text-white">Cuy!</span>
        </a>
        <button
          type="button"
          className="ml-3 inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 md:hidden"
          onClick={() => setToggleMenu()}>
          <span className="sr-only">Open main menu</span>
          <HiMenuAlt2 className="text-2xl" />
        </button>
        <input
          type="text"
          className="hidden h-9 border-none bg-gray-100 focus:ring-0 lg:block lg:w-full lg:max-w-4xl xl:max-w-5xl"
          placeholder="Search"
        />
        <div className={`${showMenu ? "" : "hidden"} w-full md:block md:w-auto`}>
          <ul className="flex flex-col rounded-lg border border-gray-100 dark:border-gray-700 dark:bg-gray-800 md:mt-0 md:flex-row md:space-x-8 md:border-0 md:text-sm md:font-medium md:dark:bg-gray-900">
            <li>
              <NavLink href={route("outer.main")} active={route().current("outer.main")}>
                <IoHomeOutline className="m-1" size={20} />
              </NavLink>
            </li>
            <li>
              <NavLink href="/teams" active={route().current("outer.teams")}>
                <FaGithub className="m-1" size={20} />
              </NavLink>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  );
};

export default NavBar;
