<?php

class ThemeHouse_ImageRestrict_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/ImageRestrict/BbCode/Formatter/Reverse.php' => 'af5aad7fa8a5497e5fefbf43c196b3a7',
                'library/ThemeHouse/ImageRestrict/ControllerHelper/ImageRestriction.php' => 'c5b9fce21b93d16e2340f6484a618ba3',
                'library/ThemeHouse/ImageRestrict/ControllerPublic/Masked.php' => 'd2c3a43d9ac414d78e988b530e97ca06',
                'library/ThemeHouse/ImageRestrict/DataWriter/Mask.php' => '625f552f696908f2deb2535417afd10a',
                'library/ThemeHouse/ImageRestrict/Extend/XenForo/ControllerPublic/Forum.php' => '0bf6e1efe36808887858b0c6d65e9215',
                'library/ThemeHouse/ImageRestrict/Extend/XenForo/ControllerPublic/Post.php' => 'dc7b0ff2424858a5ebf8024efa571d19',
                'library/ThemeHouse/ImageRestrict/Extend/XenForo/ControllerPublic/Thread.php' => '9fa74295cdfd09ea7e9acea36aa5f5d4',
                'library/ThemeHouse/ImageRestrict/Extend/XenForo/DataWriter/DiscussionMessage/Post.php' => '705d63a8d4e7e6ff7546b6be9915c83d',
                'library/ThemeHouse/ImageRestrict/Extend/XenForo/Model/Attachment.php' => '7d186ed1fd8e0f64e83879dfb1664e8c',
                'library/ThemeHouse/ImageRestrict/Extend/XenForo/Model/Post.php' => '68413ea873c2ded73d0c839f060725d4',
                'library/ThemeHouse/ImageRestrict/Install/Controller.php' => '61e5a0eea5ac42c9a4720b5ffa3a3f85',
                'library/ThemeHouse/ImageRestrict/Listener/LoadClass.php' => '08f0c8076593f157f26cf5397aeacf64',
                'library/ThemeHouse/ImageRestrict/Listener/TemplateCreate.php' => 'd4636b4307448d4adecd47541a007b61',
                'library/ThemeHouse/ImageRestrict/Listener/TemplatePostRender.php' => 'c6f75a69c0daa0a9f407658c44473f55',
                'library/ThemeHouse/ImageRestrict/Model/Mask.php' => '81fc1940765575f0c20546f63972da63',
                'library/ThemeHouse/ImageRestrict/Option.php' => '8e53df8773dd54b05109caebba097904',
                'library/ThemeHouse/ImageRestrict/Route/Prefix/Masked.php' => '7491eff762f29ccc81828fb492c4b035',
                'library/ThemeHouse/Install.php' => '18f1441e00e3742460174ab197bec0b7',
                'library/ThemeHouse/Install/20151109.php' => '2e3f16d685652ea2fa82ba11b69204f4',
                'library/ThemeHouse/Deferred.php' => 'ebab3e432fe2f42520de0e36f7f45d88',
                'library/ThemeHouse/Deferred/20150106.php' => 'a311d9aa6f9a0412eeba878417ba7ede',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
                'library/ThemeHouse/Listener/Template.php' => '0aa5e8aabb255d39cf01d671f9df0091',
                'library/ThemeHouse/Listener/Template/20150106.php' => '8d42b3b2d856af9e33b69a2ce1034442',
                'library/ThemeHouse/Listener/TemplateCreate.php' => '6bdeb679af2ea41579efde3e41e65cc7',
                'library/ThemeHouse/Listener/TemplateCreate/20150106.php' => 'c253a7a2d3a893525acf6070e9afe0dd',
                'library/ThemeHouse/Listener/TemplatePostRender.php' => 'b6da98a55074e4cde833abf576bc7b5d',
                'library/ThemeHouse/Listener/TemplatePostRender/20150106.php' => 'efccbb2b2340656d1776af01c25d9382',
            ));
    }
}