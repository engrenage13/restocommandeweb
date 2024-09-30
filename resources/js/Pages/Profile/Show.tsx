import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import Salad from "@/Layouts/SaladLayout";
import { Link, usePage } from "@inertiajs/react";

export default function Show() {
  const user = usePage().props.auth.user;

  return (
    <Salad title={`Profil - ${user.firstname} ${user.lastname}`}>
      <div>
        <div className="max-w-7xl mx-auto">
          <div className="bg-white py-2 px-4 text-center overflow-hidden shadow-sm">
            <h1 className="text-4xl font-bold text-gray-900">{user.firstname} {user.lastname}</h1>
            <p className="text-base text-gray-500">{user.email}</p>
            <div className="flex justify-center align-middle pt-3 gap-4">
              <Link href={route('profile.edit')}>
                <PrimaryButton>
                  Modifier mon profil
                </PrimaryButton>
              </Link>
              <Link href={route('logout')}>
                <SecondaryButton style={{color: 'red'}}>
                  Déconnexion
                </SecondaryButton>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </Salad>
  );
}
