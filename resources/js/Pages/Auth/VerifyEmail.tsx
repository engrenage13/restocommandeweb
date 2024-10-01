import GuestLayout from '@/Layouts/GuestLayout';
import PrimaryButton from '@/Components/Buttons/PrimaryButton';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function VerifyEmail({ status }: { status?: string }) {
  const { post, processing } = useForm({});

  const submit: FormEventHandler = (e) => {
      e.preventDefault();

      post(route('verification.send'));
  };

  return (
    <GuestLayout>
      <Head title="Vérification d'adresse mail" />
      <div className="mb-4 text-sm text-gray-600">
        Votre compte Resto Commande a été créé avec succès ! Avant de commencer, veuillez vérifier votre adresse mail en cliquant 
        sur le lien ci-dessous. Cela vous enverras un mail. Si vous ne recevez pas ce mail, vous pourrez toujours revenir ici pour en renvoyer un.
      </div>

      {status === 'verification-link-sent' && (
        <div className="mb-4 font-medium text-sm text-green-600">
          Un nouveau lien de vérification a été envoyé à l'adresse mail que vous avez utilisé pour créer votre compte.
        </div>
      )}

      <form onSubmit={submit}>
        <div className="mt-4 flex items-center justify-between">
          <PrimaryButton disabled={processing}>Renvoyez un mail de vérification</PrimaryButton>

          <Link
            href={route('logout')}
            method="post"
            as="button"
            className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Me déconnecter
          </Link>
        </div>
      </form>
    </GuestLayout>
  );
}
