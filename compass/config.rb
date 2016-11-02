# Require any additional compass plugins here.

# Set this to the root of your project when deployed:

http_path = "/wp-content/themes/wp-product-theme"
sass_dir = "sass"
css_dir = "../web/wp-content/themes/wp-product-theme/styles"
images_dir = "../web/wp-content/themes/wp-product-theme/styles/images"
javascripts_dir = "../web/wp-content/themes/wp-product-theme/js"
http_generated_images_path = "/wp-content/themes/wp-product-theme/styles/images"

# You can select your preferred output style here (can be overridden via the command line):
output_style = :compressed # :expanded or :nested or :compact or :compressed

# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false

# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass

require 'sass'
require 'cgi'

module Sass::Script::Functions

  def inline_svg_image(path, fill)
    real_path = File.join(Compass.configuration.images_path, path.value)
    svg = data(real_path)
    svg.gsub! '{color}', fill.value
    encoded_svg = CGI::escape(svg).gsub('+', '%20')
    data_url = "url('data:image/svg+xml;charset=utf-8," + encoded_svg + "')"
    Sass::Script::String.new(data_url)
  end

private

  def data(real_path)
    if File.readable?(real_path)
      File.open(real_path, "rb") {|io| io.read}
    else
      raise Compass::Error, "File not found or cannot be read: #{real_path}"
    end
  end

end