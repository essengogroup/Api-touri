<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Site;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $siteDatas = [
            [
                "name" => "Gorge de Diosso",
                "departement" => "Bouenza",
                "description" =>
                    "A une demi-heure de Pointe-Noire, des paysages fantastiques vous attendent !",
            ],
            [
                "name" => "Mvassa",
                "departement" => "Likouala",
                "description" =>
                    "Accessibles depuis Pointe-Noire, trois spots principaux permettent de surfer. Mvassa est le plus tranquille, surtout les samedis matin et la pointe rocheuse crée de belles vagues dans une baie abritée.",
            ],
            [
                "name" => "Lac loufoualeba",
                "departement" => "Plateaux",
                "description" =>
                    "Pour quelques heures, il est possible de s\'echapper de pointe-noire pour rejoindre le lac loufoualeba, aussi appele lac aux papyrus.Les papyrus semblent avoir ete plante part les colons pour fabriquer du papier de qualite. Depuis, ils ont colonise tout le bord du lac.Ce lac est le terminus de la sortie de la descente de la loeme, mais c\'est surtout un endroit accessible en voiture, vivement recommande pour une sortie ornithologie.",
            ],
            [
                "name" => "Lac Cayo",
                "departement" => "Plateaux",
                "description" =>
                    "Le lac Cayo est un deux deux grands lacs du Sud de Pointe-Noire. Le lac Loufoualeba est au Nord-Ouest, le lac Cayo au Sud Est, en aval, sur le cours de la Loémé. C\'est un endroit rarement visité, et vous le ressentirez si vous partez à la rencontre des villageois.",
            ],
            [
                "name" => "Sortie de tortue ",
                "departement" => "Bouenza",
                "description" =>
                    "Rénatura est une ONG qui protège (entre autres) les tortues marines. Sur les côtes Congolaises, plusieurs espèces peuvent être observées : Les tortues vertes et olivâtres sont les plus courantes, et plus rarement des tortues Luth. En plus d\'actions d\'éducation et de sensibilisation, cette association est présente sur le terrain pour suivre les pontes et libérer les tortues prises dans les filets des pêcheurs. Il est possible de participer à ces deux actions pour 1 0 000 CFA par adulte.",
            ],
            [
                "name" => "Malonda lunch",
                "departement" => "Bouenza",
                "description" =>
                    "Le Malonda est le seul lodge de toute la région, et de presque de tout le pays. Il vous accueille pour y passer la journée, ou un weekend !",
            ],
            [
                "name" => "Le lagune de Yombo",
                "departement" => "Bouenza",
                "description" =>
                    "A une heure de Pointe-Noire, une lagune bien cachée. Plusieurs personnes affirment avoir vu des hippopotames, ou leurs traces !",
            ],
            [
                "name" => "L’ancienne route de Diosso ",
                "departement" => "Kouilou",
                "description" =>
                    "La Baleine est un des restaurants du Bois des Singes, nom de la côte entre Pointe-Indienne et le Kouilou.",
            ],
            [
                "name" => "Lac bindi",
                "departement" => "Cuvette",
                "description" =>
                    "Un chemin le long de la Loémé, qui zigzague entre les eucalyptus. On espère voir la rivière à chaque vallée, mais ce n\'est qu\'en prenant une petite piste sauvage qu\'on découvre enfin le lac Bindi.",
            ],
            [
                "name" => "Cirque de Nzénzé",
                "departement" => "Kouilou",
                "description" =>
                    "Nzenzé veut dire étrange. Mais c\'est surtout un endroit magnifique et sauvage, perdu entre la savane Congolaise et la forêt du Mayombe.",
            ],
            [
                "name" => "Kitina",
                "departement" => "Kouilou",
                "description" =>
                    "Kitina est un grand lac, situé au milieu de la forêt, juste au pied des montagnes du Mayombe.",
            ],
            [
                "name" => "Descente de la Loémé",
                "departement" =>
                    "La Loémé est une longue rivière qui part de Les Saras sous le nom de Loukola, et qui continue ensuite le long de la frontière Cabindaise jusqu\'à se jeter dans le lac Loufoualeba. Même en plein coeur de la saison des pluies, le courant est faible et la rivière ne présente aucun risque particulier. De par sa longueur (25 km), cette sortie est quand même sportive. Les herbes et papyrus n\'offrent aucune ombre. Il ne faut donc pas oublier chapeau, lunettes, crème solaire et de quoi s\'hydrater ! C\'est une voie de navigation, pour le transport de planches de bois ou de vin de palme, ainsi qu\'une zone de pêche de petits poissons qui finiront en maboke. Des familles traversent aussi parfois sur de longues pirogues. Peu de touristes descendent cette rivière et les villageois seront contents que vous vous arrêtiez pour discuter quelques minutes. Comme toute sortie en canoë, il faut un minimum de préparation.",
            ],
            [
                "name" => "Le Kouilou",
                "departement" => "Kouilou",
                "description" =>
                    "Le Kouilou est une grande rivière mythique, remontée par la mission Marchand à la fin du XIXe siècle. En fonction du temps disponible, elle peut être remontée en pirogue à moteur jusqu\'à Kakamoeka",
            ],
            [
                "name" => "Bilinga et Bilala",
                "departement" => "Niari",
                "description" =>
                    "Ces différents villages se trouvent sur la première partie de la N1.",
            ],
            [
                "name" => "Autour de Ntombo",
                "departement" => "Niari",
                "description" =>
                    "La Ntombo est un grand marais s\'étendant au Sud du Kouilou. Des légendes racontent qu\'on rencontre des Mami Wata (probablement des lamantins d\'après les descriptions d\'époque) dans ses eaux sombres et profondes. Il est difficile d\'y accéder par la route, mais pour en avoir un petit aperçu par une jolie piste, il suffit d\'atteindre (pendant la saison sèche), le village de Kondi jusqu\'à Nzumbili. Suivre la RN5 jusqu\'à Hollemoni (CITRAD), puis sortir à droite pour prendre la piste et se diriger vers le Nord-Est. Pour arriver à Kondi, continuer sur une piste de 6 km de sable bordée de bambous et surélevée d\'un bon mètre au-dessus des marais. Enfin, il est possible de s\'enfoncer dans les marais pendant encore 6 km, mais cette partie est moins intéressante. Une autre façon d\'y aller est de passer par Hinda et Monge-Tandou. Au Sud de la piste reliant Tchiobo à Bimbakassa, un joli c irque aparait sur la gauche. Il semble être possible de s\'approcher plus près par un petit chemin depuis la piste de Nglabou, mais nous ne sommes pas allés prospecter plus près.",
            ],
            [
                "name" => "Lacs de Yanika",
                "departement" => "Niari",
                "description" =>
                    "Les lacs de Yanika sont en fait trois lacs peu profonds au Nord-Ouest de Madingo-Kayes : Ndembo, Loandjili et Loufoumbou.",
            ],
            [
                "name" => "Le lac Yangala",
                "departement" => "Kouilou",
                "description" =>
                    "Le lac Yangala est le plus poissonneux de la région, mais étrangement, aucun village ne s\'est installé à proximité. Il est alimenté par trois rivières, passant à travers la forêt, qui apportent de la terre.L\'eau est donc assez sombre et ne donne pas très envie de s\'y baigner.Par contre, il est tout à fait possible d\'y faire du canoë.",
            ],
            [
                "name" => "Point Kuonda",
                "departement" => "Kouilou",
                "description" =>
                    "Juste avant la Noumbi, un spot de surf qui fonctionne presque tout le temps, et surtout une jolie escapade à quelques heures de PointeNoire",
            ],
            [
                "name" => "Les saras",
                "departement" => "Lekoumou",
                "description" =>
                    "Au coeur du Mayombe, un village autrefois prospère grâce au commerce de la banane via le chemin de fer CFCO, le bois et la prospection d\'or. Le nom vient de la population \'Sara\', originaire du Tchad, qui fût utilisée pour la construction de la voie ferrée.La CFCO construira dans les années 1980 une voie de contournement, passant plus près de la frontière Cabindaiseréduisant le nombre de trains hebdomadaires. Mais l\'arrivée de la RN1 goudronnée a permis aux taxis et aux camions de rejoindre Pointe-Noire.",
            ],
            [
                "name" => "Dimonika",
                "departement" => "Niari",
                "description" =>
                    "La réserve de la biosphère de Dimonika est un parc de 136 000 ha, entre Pointe-Noire et Dolisie. De nombreuses idées de développement sont en gestation, avec quelques financements d\'ONG, mais rien n\'a été vraiment réalisé pour l\'instant. Il est quand même possible d\'y faire des marches et avec un peu de chance, rencontrer des animaux : En 2009, une étude de l\'institut Jane Goodall a confirmé la présence de 1 00 gorilles.",
            ],
            [
                "name" => "Tonton mac et la joie de vivre",
                "departement" => "Niari",
                "description" =>
                    "Moins de deux heures de piste, deux villages au bord de l\'océan, distants de 3 km kilomètres. Ce n\'est pas l\'endroit le plus paradisiaque du Congo, mais c\'est quand même un lieu à connaitre.",
            ],
            [
                "name" => "Dolisie",
                "departement" => "Niari",
                "description" =>
                    "Il fut un temps où aller à Dolisie était une expédition de plusieurs jours, surtout pendant la saison des pluies. Aujourd\'hui, avec la nouvelle RN1, il est très facile d\'y passer le weekend.- Idée de weekend à DolisieLe classique : Partir le vendredi dans l\'après-midi pour dormir à Dolisie le soir. Le samedi, faire l\'aller-retour vers la rivière bleue. Enfin, le dimanche matin, passer au marché, puis aller jusqu\'à la chute. Déjeuner à Dolisie, puis rentrer sur Pointe-Noire.Une boucle : Partir le vendredi pour dormir à Dolisie. Le Samedi aller à rivière bleue et y camper (ou camper aux monts de la lune). Le dimanche, rentrer par la piste des grumiers.Rivière et cascade : Partir le samedi de Pointe-Noire. S\'arrêter déjeuner à Les Saras et y faire une promenade au bord de la rivière. Repartir et dormir à Dolisie. Le dimanche, aller au marché et jusqu\'à la chute, puis rentrer sur Pointe-Noire.Montagnes et cascade : Comme la formule rivière et cascade, mais en s\'arrêtant la journée à Dimonika pour marcher dans la forêt.",
            ],
            [
                "name" => "Conkouati",
                "departement" => "Niari",
                "description" =>
                    "En bateau, en voiture ou à pied, Conkouati est un très beau parc naturel, facilement accessible depuis Pointe-Noire. A cinq heures de Pointe-Noire, de nombreux animaux vous attendent, dont des éléphants, des chimpanzés, des buffles et parfois même des gorilles.",
            ],
            [
                "name" => "Makabana",
                "departement" => "Pool",
                "description" =>
                    "Aller à Makabana, c\'est rentrer au coeur de la forêt, à la rencontre des forestiers.",
            ],
            [
                "name" => "Sibiti et zanaga",
                "departement" => "Pool",
                "description" =>
                    "Un long voyage avec 1 000 km au compteur, mais une belle surprise en arrivant au bout !",
            ],
            [
                "name" => "kakamoéka",
                "departement" => "Kouilou",
                "description" =>
                    "Kakamoeka, la ville des chercheurs d\'or, perdue au milieu du Mayombe.",
            ],
            [
                "name" => "Autour de loaka",
                "departement" => "Kouilou",
                "description" =>
                    "Il n\'est pas nécessaire de faire des milliers de kilomètres pour voir des Gorilles depuis Pointe-Noire. Certains se trouvent dans la réserve de Conkouati, mais aussi plus près, autour de Loaka. Mais Pour espérer en rencontrer, il faudra camper en forêt. Voir un gorille sauvage se mérite !",
            ],
            [
                "name" => "Tour du mayombe",
                "departement" => "Kouilou",
                "description" =>
                    "Une longue balade (près de 500 km) mais qui permet de traverser deux fois le Mayombe par des pistes bien différentes et voir de nombreux paysages de savane et forêts.",
            ],
            [
                "name" => "Divénié",
                "departement" => "Plateaux",
                "description" =>
                    "Avant de partir, vous pouvez prendre des renseignements auprès de Jean Nzoho, conférencier et professeur de Munukutuba, originaire de Divénié.",
            ],
            [
                "name" => "Brazzaville",
                "departement" => "Brazzaville",
                "description" =>
                    "En venant de Pointe-Noire, Brazzaville surprend par sa propreté, son étendue, ses espaces verts, ses immeubles modernes. De grandes artères bitumées en bon état, avec de larges trottoirs permettant de découvrir le centre à pied, pas de détritus. Les ronds-points sont agrémentés de fontaines, qui fonctionnent, et de statues. Ses habitants sont accueillants et sympathiques, et engagent facilement la discussion.",
            ],
            [
                "name" => "Lefini",
                "departement" => "Plateaux",
                "description" =>
                    "La réserve de la Léfini, créée en 1951, s\'étend sur 650 000 hectares. Sa proximité avec Brazzaville rend son accès très facile, mais a aussi contribué à la disparition de sa faune, par la forte demande de viande de chasse par la population aux alentours. Il est difficile aujourd\'hui d\'y observer des animaux sauvages sans y rester plusieurs jours, mais le paysage de forêts et savane, traversé par plusieurs rivières (la Léfini, la Lésio et la Louna) vaut le détour à lui seul. La réserve Lésio-Louna est la partie sud de la réserve Léfini. Cette zone est gérée par la fondation Projet de Protection des Gorilles (PPG), qui travaille à la réintroduction des gorilles orphelins dans leur milieu naturel. Mieux vaut réserver en avance auprès de Berthin ou Florent. Il faut ensuite payer au bureau de PPG à Brazzaville ou directement au camp d\'lboubikro.",
            ],
            [
                "name" => "Le nord Nouabalé Ndoki",
                "departement" => "Plateaux",
                "description" =>
                    "Le Nord du Congo est une région très riche sur le plan culturel, avec une faune et une flore dense et variée. Des peuples pygmées seminomades y vivent encore et de nombreuses ethnies bantoues ont su garder leurs rites et coutumes. Les différentes réserves, encore préservées du braconnage et de la déforestation, permettent d\'observer des animaux en liberté.",
            ],
        ];

        foreach ($siteDatas as $siteData) {
            $site = Site::factory()->create([
                'name' => $siteData['name'],
//                'description' => $siteData['description'],
                'price' =>
                    Factory::create()->numberBetween(1000, 100000),
                'latitude' => Factory::create()->latitude,
                'longitude' => Factory::create()->longitude,
            ]);
        }

        /*Departement::all()->each(function ($departement) use ($siteDatas) {
            $departement->sites()->createMany(
                collect($siteDatas)->filter(function ($siteData) use ($departement) {
                    return $siteData['departement'] === $departement->name;
                })->map(function ($siteData) {
                    return [
                        'name' => $siteData['name'],
                        'description' => $siteData['description'],
                        'price' =>
                            Factory::create()->numberBetween(1000, 100000),
                        'latitude' => Factory::create()->latitude,
                        'longitude' => Factory::create()->longitude,
                    ];
                })->toArray()
            );
        });*/
    }
}
