
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<atom:link href="{$AbsoluteLink}rss" rel="self" type="application/rss+xml" />

<title>88.5 FM Live Sessions podcast</title>
<link>https://www.885fm.org/live-sessions</link>
<language>en-us</language>
<copyright>88.5FM &#xA9;2020</copyright>

<itunes:author>https://www.885fm.org/</itunes:author>
<description>Live Sessions recorded live for 88.5 FM</description>
    <itunes:owner>
        <itunes:name>88.5 FM</itunes:name>
        <itunes:email>feedback@885FM.org</itunes:email>
    </itunes:owner>
    <itunes:category text="Music">
        <itunes:category text="Music Interviews" />
    </itunes:category>
    <itunes:summary>Live Sessions recorded live for 88.5 FM</itunes:summary>
    <itunes:subtitle>Live Sessions recorded live for 88.5 FM</itunes:subtitle>
    <itunes:image href="https://www.885fm.org/assets/Uploads/885FM-ORG-885-Grid-Beveled-Vector-iterations-Colored-web-10tilt.png" />
    <pubDate>Fri, 07 Aug 2020 09:00:00 GMT</pubDate>
    <lastBuildDate>Fri, 07 Aug 2020 09:00:00 GMT</lastBuildDate>

<%--<% if $podcastEpisodes %><% loop $podcastEpisodes %>
<item>
	<% if $EpisodeTitle %><title>$EpisodeTitle.XML</title><% end_if %>
	<% if $EpisodeAuthor %><itunes:author>$EpisodeAuthor.XML</itunes:author><% end_if %>
	<% if $EpisodeSubtitle %><itunes:subtitle>$EpisodeSubtitle.XML</itunes:subtitle><% end_if %>
	<% if $EpisodeSummary %><itunes:summary>$EpisodeSummary.NoHTML.XML</itunes:summary>
	<description>$EpisodeSummary.NoHTML.XML</description><% end_if %>
	<% if $EpisodeImage %><itunes:image href="$EpisodeImage.getAbsoluteURL" /><% end_if %>
	<% if $EpisodeFile %><enclosure url="$EpisodeFile.getAbsoluteURL" length="$EpisodeFile.getAbsoluteSize" type="$getMime" />
	<guid>$EpisodeLink</guid><% end_if %>
	<% if $EpisodeDate %><pubDate>$EpisodeDate.Rfc822</pubDate><% else %><pubDate>$Created.Rfc822</pubDate><% end_if %>
	<% if $EpisodeDuration %><itunes:duration>$EpisodeDuration</itunes:duration><% end_if %>
	<% if $BlockEpisode %><itunes:block>yes</itunes:block><% end_if %>
	<% if $ExplicitEpisode %><itunes:explicit>$ExplicitEpisode</itunes:explicit><% end_if %>
</item>
<% end_loop %><% end_if %>--%>

</channel>
</rss>
