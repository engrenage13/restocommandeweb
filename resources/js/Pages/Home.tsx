import Salad from "@/Layouts/SaladLayout";

export default function Home() {
  return (
    <Salad title='Accueil'>
      <div className="py-3">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">Bonjour !</div>
          </div>
        </div>
      </div>
    </Salad>
  );
}
