<?php

class PodcastEpisode extends DataObject
{
    private static $has_one = array(
        'EpisodeFile' => 'File'
        ,'EpisodeImage' => 'Image'
        ,'PodcastPage' => 'PodcastPage'
    );

    private static $db = array(
        'EpisodeTitle' => 'VarChar(255)'
        ,'EpisodeSubtitle' => 'VarChar(255)'
        ,'EpisodeSummary' => 'HTMLText'
        ,'EpisodeAuthor' => 'VarChar(127)'
        ,'BlockEpisode' => 'Boolean'
        ,'ExplicitEpisode' => 'enum("No, Clean, Yes");'
        ,'EpisodeDate' => 'SS_Datetime'
        ,'EpisodeDuration' => 'Time'
    );

    private static $searchable_fields = array(
        'EpisodeTitle'
        ,'EpisodeSubtitle'
        ,'EpisodeAuthor'
        ,'BlockEpisode'
        ,'ExplicitEpisode'
        ,'EpisodeDate'
    );

    private static $summary_fields = array(
        'EpisodeThumb' => 'Image'
        ,'EpisodeDate' => 'Date'
        ,'EpisodeTitle' => 'Title'
        ,'EpisodeDuration' => 'Duration'
    );

    private static $better_buttons_actions = array(
        'getTags'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->fieldByName('Root.Main.EpisodeDate')->dateField
            ->setConfig('showcalendar', true)
            ->setConfig('dateformat', 'dd/MM/YYYY');
        $fields->fieldByName('Root.Main.EpisodeDate')->timeField
            ->setConfig('timeformat', 'HH:mm');
        $fields->fieldByName('Root.Main.EpisodeDate')
            ->setDescription('Date when the episode was published.')
            ->setValue(date('r'));

        $fields->fieldByName('Root.Main.EpisodeDuration')
            ->setConfig('timeformat', 'HH:mm:ss')
            ->setDescription('In the format HH:mm:ss e.g. 00:56:18');

        $fields->fieldByName('Root.Main.BlockEpisode')
            ->setDescription('Prevent the <strong>episode</strong> from appearing in the iTunes podcast directory.');
        $fields->fieldByName('Root.Main.ExplicitEpisode')
            ->setDescription("Displays an 'Explicit', 'Clean' or no parental advisory graphic next to your episode in iTunes.");

        $fields->fieldByName('Root.Main.EpisodeFile')
            ->setFolderName('podcast/episodes')
            ->getValidator()->setAllowedExtensions(array(
                'pdf',
                'epub',
                'mp3',
                'wav',
                'm4a',
                'm4v',
                'mp4',
                'mov',
            ));

        $fields->fieldByName('Root.Main.EpisodeImage')
            ->setFolderName('podcast/episode-images')
            ->getValidator()->setAllowedExtensions(array('jpg', 'png'));

        return $fields;
    }

    public function getBetterButtonsUtils()
    {
        $fields = parent::getBetterButtonsUtils();
        $fields->push(
            BetterButtonCustomAction::create('getTags', 'Get ID3 Tags')
            ->setRedirectType(BetterButtonCustomAction::REFRESH)
        );

        return $fields;
    }


    /**
    * Returns the episode's title
    * @return string
    */
    public function getTitle()
    {
        return $this->EpisodeTitle;
    }

    /**
    * Returns the absolute link to the episode's page
    * @return string
    */
    public function episodeLink()
    {
        return $this->PodcastPage()->AbsoluteLink('episode/' . $this->ID);
    }

    /**
    * Returns the relative link to the episode's page
    * @return string
    */
    public function relativeEpisodeLink()
    {
        return $this->PodcastPage()->RelativeLink('episode/' . $this->ID);
    }

    /**
    * Returns a thumbnail of the Episode Image
    * @return Image
    */
    public function episodeThumb()
    {
        return $this->EpisodeImage()->fill(40, 40);
    }

    /**
    * Returns mime type for use in PodcastRSS enclosure
    * @return string
    */
    public function getMime()
    {
        // return an empty string if there's no file
        if (!$this->EpisodeFileID) {
            return '';
        }

        $filename = $this->EpisodeFile()->getFilename();
        $filename = explode('.', $filename);

        $mime_types = array(
            'pdf' => 'application/pdf',
            'epub' => 'document/x-epub',
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/x-wav',
            'm4a' => 'audio/x-m4a',
            'm4v' => 'video/x-m4v',
            'mp4' => 'video/mp4',
            'mov' => 'video/quicktime',
        );

        $extension = strtolower(end($filename));

        return $mime_types[$extension];
    }

    /**
    * Returns the type for page template for audio, video tags or download link
    * @return string
    */
    public function getType()
    {
        if (!$this->EpisodeFileID) {
            return '';
        }
        $mime = explode('/', $this->getMime());

        return $mime[0];
    }

    public function getTags()
    {
        if (!$this->EpisodeFileID) {
            return '';
        }
        $getID3 = new \getID3;
        $file = $getID3->analyze($this->EpisodeFile()->FullPath);
        $tags = $file['tags']['id3v2'];
        if (!empty($tags)) {
            $this->EpisodeTitle = $tags['title'][0] ? $tags['title'][0] : '';
            $this->EpisodeAuthor = $tags['artist'][0] ? $tags['artist'][0] : '';
            $this->EpisodeSummary = $tags['comment'][0] ? $tags['comment'][0] : '';
            $this->EpisodeDuration = $file['playtime_seconds'] ? gmdate('H:i:s', $file['playtime_seconds']) : '';
            $this->write();
        }
    }

    public function canView($member = null)
    {
        return true;
    }

    public function canEdit($member = null)
    {
        return Permission::check('PODCAST_ADMIN');
    }

    public function canDelete($member = null)
    {
        return Permission::check('PODCAST_ADMIN');
    }

    public function canCreate($member = null)
    {
        return Permission::check('PODCAST_ADMIN');
    }
}
